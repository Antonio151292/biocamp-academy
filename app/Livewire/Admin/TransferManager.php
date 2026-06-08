<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Purchase;
use App\Models\Subscription;

class TransferManager extends Component
{
    public $activeTab = 'pending'; // pending, history

    public function approvePurchase($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->update(['status' => 'approved']);
        session()->flash('message', 'Compra de curso aprobada con éxito. El estudiante ya tiene acceso.');
    }

    public function rejectPurchase($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->update(['status' => 'rejected']);
        session()->flash('message', 'Compra de curso rechazada.');
    }

    public function approveSubscription($id)
    {
        $sub = Subscription::findOrFail($id);
        
        $duration = $sub->plan_type === 'anual' ? 365 : 30;
        $sub->update([
            'status' => 'active',
            'starts_at' => now(),
            'ends_at' => now()->addDays($duration),
        ]);

        session()->flash('message', 'Suscripción aprobada con éxito. El estudiante tiene acceso total.');
    }

    public function rejectSubscription($id)
    {
        $sub = Subscription::findOrFail($id);
        $sub->update(['status' => 'expired']); // marked as expired to deny access
        session()->flash('message', 'Suscripción rechazada.');
    }

    public function render()
    {
        if ($this->activeTab === 'pending') {
            $pendingPurchases = Purchase::with(['user', 'course'])
                ->where('payment_method', 'transferencia')
                ->where('status', 'pending')
                ->latest()
                ->get();

            $pendingSubscriptions = Subscription::with(['user'])
                ->where('payment_method', 'transferencia')
                ->where('status', 'pending')
                ->latest()
                ->get();
        } else {
            $pendingPurchases = Purchase::with(['user', 'course'])
                ->where('payment_method', 'transferencia')
                ->whereIn('status', ['approved', 'rejected'])
                ->latest()
                ->get();

            $pendingSubscriptions = Subscription::with(['user'])
                ->where('payment_method', 'transferencia')
                ->whereIn('status', ['active', 'expired'])
                ->latest()
                ->get();
        }

        return view('livewire.admin.transfer-manager', compact('pendingPurchases', 'pendingSubscriptions'))
            ->layout('layouts.admin');
    }
}
