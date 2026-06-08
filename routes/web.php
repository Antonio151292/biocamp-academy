<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\CourseManager;
use App\Livewire\Admin\CourseEditor;
use App\Livewire\Admin\TransferManager;
use App\Livewire\Admin\PaymentSettings;
use App\Livewire\Admin\RoleManager;
use App\Livewire\Admin\PageBuilder;

use App\Livewire\Catalog;
use App\Livewire\CourseDetail;
use App\Livewire\LessonViewer;
use App\Livewire\SubscriptionPlans;
use App\Livewire\Checkout;

use App\Models\Page;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\Subscription;
use Illuminate\Support\Str;

Route::get('/', function () {
    $page = Page::where('name', 'home')->first();
    $sections = $page ? $page->content : [];
    $publishedCourses = Course::where('is_published', true)->latest()->take(6)->get();
    return view('welcome', compact('sections', 'publishedCourses'));
});

Route::get('/catalog', Catalog::class)->name('courses.catalog');
Route::get('/courses/{slug}', CourseDetail::class)->name('courses.detail');
Route::get('/subscription', SubscriptionPlans::class)->name('subscription.plans');

// Admin panel routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin'
])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/courses', CourseManager::class)->name('courses.index');
    Route::get('/courses/{course}/edit', CourseEditor::class)->name('courses.edit');
    Route::get('/payments/transfers', TransferManager::class)->name('payments.transfers');
    Route::get('/settings/payments', PaymentSettings::class)->name('settings.payments');
    Route::get('/roles', RoleManager::class)->name('roles');
    Route::get('/page-builder', PageBuilder::class)->name('page-builder');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/courses/{courseSlug}/lessons/{lessonSlug}', LessonViewer::class)->name('courses.lessons.show')->middleware('course.access');
    Route::get('/checkout/{type}/{key}', Checkout::class)->name('checkout');
    
    // Gateway success/pending/failure callback
    Route::get('/payment/callback/{status}', function ($status) {
        $type = request('type');
        $key = request('key');
        $method = request('method', 'gateway');
        
        if ($status === 'success' && auth()->check()) {
            $userId = auth()->id();
            $txId = 'TX-' . strtoupper(Str::random(12));
            
            if ($type === 'course') {
                $course = Course::where('slug', $key)->first();
                if ($course) {
                    Purchase::create([
                        'user_id' => $userId,
                        'course_id' => $course->id,
                        'payment_method' => $method,
                        'transaction_id' => $txId,
                        'status' => 'approved',
                        'amount' => $course->price,
                    ]);
                    session()->flash('success_message', '¡Compra aprobada con éxito! Ya puedes iniciar el curso.');
                    return redirect()->route('courses.detail', $course->slug);
                }
            } else {
                $duration = $key === 'anual' ? 365 : 30;
                Subscription::create([
                    'user_id' => $userId,
                    'plan_type' => $key,
                    'payment_method' => $method,
                    'subscription_id' => $txId,
                    'status' => 'active',
                    'starts_at' => now(),
                    'ends_at' => now()->addDays($duration),
                ]);
                session()->flash('success_message', '¡Suscripción mensual/anual activada! Tienes acceso total a los cursos.');
                return redirect()->route('courses.catalog');
            }
        }
        
        return redirect()->route('courses.catalog');
    })->name('payment.gateway.callback');
});
