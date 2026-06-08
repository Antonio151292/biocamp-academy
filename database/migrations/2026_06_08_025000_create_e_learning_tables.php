<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Courses Table
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2)->default(0.00);
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });

        // 2. Sections Table
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('title');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // 3. Lessons Table
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->text('content')->nullable();
            $table->string('video_provider')->default('local'); // 'local' or 'drive'
            $table->string('video_url')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_free')->default(false);
            $table->timestamps();
        });

        // 4. Lesson User (completed lessons tracker)
        Schema::create('lesson_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        // 5. Purchases Table
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('payment_method'); // 'mercadopago', 'paypal', 'transferencia'
            $table->string('transaction_id')->nullable();
            $table->string('status')->default('pending'); // 'pending', 'approved', 'rejected'
            $table->decimal('amount', 8, 2);
            $table->string('receipt_path')->nullable();
            $table->timestamps();
        });

        // 6. Subscriptions Table
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('plan_type'); // 'mensual', 'anual'
            $table->string('payment_method'); // 'mercadopago', 'paypal', 'transferencia'
            $table->string('subscription_id')->nullable();
            $table->string('status')->default('pending'); // 'pending', 'active', 'expired', 'cancelled'
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->string('receipt_path')->nullable();
            $table->timestamps();
        });

        // 7. Groups Table (Communities per Course)
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 8. Group Messages Table (Real-time chat)
        Schema::create('group_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('content');
            $table->timestamps();
        });

        // 9. Group User (Pivot for members of a group)
        Schema::create('group_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // 10. Forum Questions Table (Q&A forum)
        Schema::create('forum_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->timestamps();
        });

        // 11. Forum Answers Table
        Schema::create('forum_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('forum_questions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('content');
            $table->timestamps();
        });

        // 12. Settings Table
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // 13. Pages Table (Visual Template sections)
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // 'home'
            $table->string('title');
            $table->json('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('forum_answers');
        Schema::dropIfExists('forum_questions');
        Schema::dropIfExists('group_user');
        Schema::dropIfExists('group_messages');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('lesson_user');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('courses');
    }
};
