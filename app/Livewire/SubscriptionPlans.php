<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subscription;

class SubscriptionPlans extends Component
{
    public $activeSubscription = null;

    public function mount()
    {
        if (auth()->check()) {
            $this->activeSubscription = Subscription::where('user_id', auth()->id())
                ->where('status', 'active')
                ->where(function($query) {
                    $query->whereNull('ends_at')
                          ->orWhere('ends_at', '>', now());
                })
                ->first();
        }
    }

    public function render()
    {
        return view('livewire.subscription-plans')
            ->layout('layouts.student');
    }
}
