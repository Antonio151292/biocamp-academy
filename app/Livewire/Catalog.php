<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Subscription;

class Catalog extends Component
{
    public $search = '';

    public function render()
    {
        $courses = Course::where('is_published', true)
            ->where('title', 'like', '%' . $this->search . '%')
            ->latest()
            ->get();

        $hasActiveSubscription = false;
        if (auth()->check()) {
            $hasActiveSubscription = Subscription::where('user_id', auth()->id())
                ->where('status', 'active')
                ->where(function($query) {
                    $query->whereNull('ends_at')
                          ->orWhere('ends_at', '>', now());
                })
                ->exists();
        }

        return view('livewire.catalog', compact('courses', 'hasActiveSubscription'))
            ->layout('layouts.student');
    }
}
