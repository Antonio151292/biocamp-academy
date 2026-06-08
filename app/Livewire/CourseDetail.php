<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\Subscription;

class CourseDetail extends Component
{
    public Course $course;
    public $hasAccess = false;

    public function mount($slug)
    {
        $this->course = Course::where('slug', $slug)->firstOrFail();

        if (auth()->check()) {
            $userId = auth()->id();

            // Check if the user bought the course
            $hasPurchase = Purchase::where('user_id', $userId)
                ->where('course_id', $this->course->id)
                ->where('status', 'approved')
                ->exists();

            // Check if the user has an active subscription
            $hasActiveSubscription = Subscription::where('user_id', $userId)
                ->where('status', 'active')
                ->where(function($query) {
                    $query->whereNull('ends_at')
                          ->orWhere('ends_at', '>', now());
                })
                ->exists();

            $this->hasAccess = $hasPurchase || $hasActiveSubscription || auth()->user()->hasRole('admin');
        }
    }

    public function render()
    {
        $sections = $this->course->sections()->with('lessons')->get();
        
        return view('livewire.course-detail', compact('sections'))
            ->layout('layouts.student');
    }
}
