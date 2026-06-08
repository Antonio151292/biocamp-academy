<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\Subscription;

class CheckCourseAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $courseSlug = $request->route('courseSlug');
        
        if ($courseSlug) {
            $course = Course::where('slug', $courseSlug)->first();
            if ($course && auth()->check()) {
                $userId = auth()->id();

                if (auth()->user()->hasRole('admin')) {
                    return $next($request);
                }

                $hasPurchase = Purchase::where('user_id', $userId)
                    ->where('course_id', $course->id)
                    ->where('status', 'approved')
                    ->exists();

                $hasActiveSubscription = Subscription::where('user_id', $userId)
                    ->where('status', 'active')
                    ->where(function($query) {
                        $query->whereNull('ends_at')
                              ->orWhere('ends_at', '>', now());
                    })
                    ->exists();

                if ($hasPurchase || $hasActiveSubscription) {
                    return $next($request);
                }
            }
        }

        session()->flash('error', 'No tienes acceso a este curso. Adquiérelo o contrata una suscripción.');
        return redirect()->route('courses.catalog');
    }
}
