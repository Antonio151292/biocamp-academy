<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Setting;

class PaymentSettings extends Component
{
    // Payment Mode
    public $payment_mode = 'sandbox'; // sandbox or live

    // PayPal Credentials
    public $paypal_sandbox_client_id = '';
    public $paypal_sandbox_secret = '';
    public $paypal_live_client_id = '';
    public $paypal_live_secret = '';

    // MercadoPago Credentials
    public $mercadopago_sandbox_public_key = '';
    public $mercadopago_sandbox_access_token = '';
    public $mercadopago_live_public_key = '';
    public $mercadopago_live_access_token = '';

    // Bank Details
    public $bank_transfer_instructions = '';

    public function mount()
    {
        $this->payment_mode = Setting::get('payment_mode', 'sandbox');
        
        $this->paypal_sandbox_client_id = Setting::get('paypal_sandbox_client_id', '');
        $this->paypal_sandbox_secret = Setting::get('paypal_sandbox_secret', '');
        $this->paypal_live_client_id = Setting::get('paypal_live_client_id', '');
        $this->paypal_live_secret = Setting::get('paypal_live_secret', '');

        $this->mercadopago_sandbox_public_key = Setting::get('mercadopago_sandbox_public_key', '');
        $this->mercadopago_sandbox_access_token = Setting::get('mercadopago_sandbox_access_token', '');
        $this->mercadopago_live_public_key = Setting::get('mercadopago_live_public_key', '');
        $this->mercadopago_live_access_token = Setting::get('mercadopago_live_access_token', '');

        $this->bank_transfer_instructions = Setting::get('bank_transfer_instructions', '');
    }

    public function togglePaymentMode()
    {
        $this->payment_mode = $this->payment_mode === 'sandbox' ? 'live' : 'sandbox';
        Setting::set('payment_mode', $this->payment_mode);
        session()->flash('message', 'Modo de pago cambiado a: ' . ($this->payment_mode === 'sandbox' ? 'SANDBOX (Pruebas)' : 'PRODUCTIVO (En Vivo)'));
    }

    public function saveSettings()
    {
        Setting::set('paypal_sandbox_client_id', $this->paypal_sandbox_client_id);
        Setting::set('paypal_sandbox_secret', $this->paypal_sandbox_secret);
        Setting::set('paypal_live_client_id', $this->paypal_live_client_id);
        Setting::set('paypal_live_secret', $this->paypal_live_secret);

        Setting::set('mercadopago_sandbox_public_key', $this->mercadopago_sandbox_public_key);
        Setting::set('mercadopago_sandbox_access_token', $this->mercadopago_sandbox_access_token);
        Setting::set('mercadopago_live_public_key', $this->mercadopago_live_public_key);
        Setting::set('mercadopago_live_access_token', $this->mercadopago_live_access_token);

        Setting::set('bank_transfer_instructions', $this->bank_transfer_instructions);

        session()->flash('message', 'Ajustes de pago guardados correctamente.');
    }

    public function render()
    {
        return view('livewire.admin.payment-settings')
            ->layout('layouts.admin');
    }
}
