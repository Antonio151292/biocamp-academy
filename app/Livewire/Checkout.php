<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\Subscription;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class Checkout extends Component
{
    use WithFileUploads;

    public $type; // 'course' or 'subscription'
    public $key;  // course slug or plan type 'mensual'/'anual'
    
    public $course = null;
    public $amount = 0.00;
    public $planName = '';
    
    public $paymentMethod = 'transferencia'; // 'transferencia', 'paypal', 'mercadopago'
    public $bankInstructions = '';

    // File upload
    public $receiptFile;

    // Credentials status flags
    public $paypalConfigured = false;
    public $mercadopagoConfigured = false;
    public $paymentMode = 'sandbox';

    public function mount($type, $key)
    {
        $this->type = $type;
        $this->key = $key;
        $this->paymentMode = Setting::get('payment_mode', 'sandbox');

        if ($type === 'course') {
            $this->course = Course::where('slug', $key)->firstOrFail();
            $this->amount = $this->course->price;
            $this->planName = 'Acceso Permanente: ' . $this->course->title;
        } else {
            if (!in_array($key, ['mensual', 'anual'])) {
                abort(404);
            }
            $this->amount = $key === 'anual' ? 149.00 : 19.00;
            $this->planName = 'Suscripción ' . ucfirst($key);
        }

        $this->bankInstructions = Setting::get('bank_transfer_instructions', 'Realiza tu depósito en el banco de tu preferencia y sube el comprobante aquí.');

        // Validate configurations
        $this->checkGatewayConfigs();
    }

    protected function checkGatewayConfigs()
    {
        if ($this->paymentMode === 'live') {
            $this->paypalConfigured = !empty(Setting::get('paypal_live_client_id')) && !empty(Setting::get('paypal_live_secret'));
            $this->mercadopagoConfigured = !empty(Setting::get('mercadopago_live_access_token'));
        } else {
            $this->paypalConfigured = !empty(Setting::get('paypal_sandbox_client_id')) && !empty(Setting::get('paypal_sandbox_secret'));
            $this->mercadopagoConfigured = !empty(Setting::get('mercadopago_sandbox_access_token'));
        }
    }

    public function processTransfer()
    {
        $this->validate([
            'receiptFile' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $filePath = $this->receiptFile->store('receipts', 'public');
        $userId = auth()->id();

        if ($this->type === 'course') {
            Purchase::create([
                'user_id' => $userId,
                'course_id' => $this->course->id,
                'payment_method' => 'transferencia',
                'status' => 'pending',
                'amount' => $this->amount,
                'receipt_path' => $filePath,
            ]);
            session()->flash('message', 'Comprobante de transferencia subido. El administrador activará tu acceso tras verificar la transacción.');
        } else {
            Subscription::create([
                'user_id' => $userId,
                'plan_type' => $this->key,
                'payment_method' => 'transferencia',
                'status' => 'pending',
                'receipt_path' => $filePath,
            ]);
            session()->flash('message', 'Comprobante de suscripción subido. El administrador activará tu suscripción tras verificar la transacción.');
        }

        return redirect()->route('courses.catalog');
    }

    public function processGatewayPayment()
    {
        if ($this->paymentMethod === 'paypal') {
            return $this->redirectToPayPal();
        } elseif ($this->paymentMethod === 'mercadopago') {
            return $this->redirectToMercadoPago();
        }
    }

    protected function redirectToPayPal()
    {
        // For testing / sandbox without valid API credentials
        if (!$this->paypalConfigured) {
            session()->flash('gateway_error', 'Falta configurar las credenciales de PayPal. Usaremos la simulación para continuar.');
            return;
        }

        // Logic placeholder for real PayPal Order creation redirect
        // We simulate success since sandbox requires real client parameters
        return $this->simulateSuccess();
    }

    protected function redirectToMercadoPago()
    {
        if (!$this->mercadopagoConfigured) {
            session()->flash('gateway_error', 'Falta configurar las credenciales de MercadoPago. Usaremos la simulación para continuar.');
            return;
        }

        $accessToken = $this->paymentMode === 'live' 
            ? Setting::get('mercadopago_live_access_token') 
            : Setting::get('mercadopago_sandbox_access_token');

        // Create MercadoPago preference via HTTP POST API call
        $response = Http::withToken($accessToken)
            ->post('https://api.mercadopago.com/checkout/preferences', [
                'items' => [
                    [
                        'title' => $this->planName,
                        'quantity' => 1,
                        'unit_price' => (float)$this->amount,
                        'currency_id' => 'MXN', // or USD
                    ]
                ],
                'back_urls' => [
                    'success' => route('payment.gateway.callback', ['status' => 'success', 'type' => $this->type, 'key' => $this->key, 'method' => 'mercadopago']),
                    'failure' => route('courses.catalog'),
                    'pending' => route('courses.catalog'),
                ],
                'auto_return' => 'approved',
            ]);

        if ($response->successful()) {
            $initPoint = $response->json()['init_point'] ?? null;
            if ($initPoint) {
                return redirect()->away($initPoint);
            }
        }

        session()->flash('gateway_error', 'Error al crear la preferencia de MercadoPago. Inténtalo de nuevo.');
    }

    public function simulateSuccess()
    {
        $userId = auth()->id();
        $txId = 'TX-' . strtoupper(Str::random(12));

        if ($this->type === 'course') {
            Purchase::create([
                'user_id' => $userId,
                'course_id' => $this->course->id,
                'payment_method' => $this->paymentMethod,
                'transaction_id' => $txId,
                'status' => 'approved',
                'amount' => $this->amount,
            ]);
            session()->flash('success_message', '¡Compra aprobada con éxito! Ya puedes iniciar el curso.');
            return redirect()->route('courses.detail', $this->course->slug);
        } else {
            $duration = $this->key === 'anual' ? 365 : 30;
            Subscription::create([
                'user_id' => $userId,
                'plan_type' => $this->key,
                'payment_method' => $this->paymentMethod,
                'subscription_id' => $txId,
                'status' => 'active',
                'starts_at' => now(),
                'ends_at' => now()->addDays($duration),
            ]);
            session()->flash('success_message', '¡Suscripción mensual/anual activada! Tienes acceso total a los cursos.');
            return redirect()->route('courses.catalog');
        }
    }

    public function render()
    {
        return view('livewire.checkout')
            ->layout('layouts.student');
    }
}
