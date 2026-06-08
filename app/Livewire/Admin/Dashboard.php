<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\Subscription;

class Dashboard extends Component
{
    /**
     * Render the admin dashboard.
     */
    public function render()
    {
        $totalStudents = User::role('student')->count();
        $totalCourses = Course::count();
        $totalEarnings = Purchase::where('status', 'approved')->sum('amount');
        
        $pendingTransfers = Purchase::where('payment_method', 'transferencia')
            ->where('status', 'pending')
            ->count() + Subscription::where('payment_method', 'transferencia')
            ->where('status', 'pending')
            ->count();

        $recentPurchases = Purchase::with(['user', 'course'])
            ->latest()
            ->take(5)
            ->get();

        $recentSubscriptions = Subscription::with(['user'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', compact(
            'totalStudents',
            'totalCourses',
            'totalEarnings',
            'pendingTransfers',
            'recentPurchases',
            'recentSubscriptions'
        ))->layout('layouts.admin');
    }
}
