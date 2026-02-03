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
        // Enrollments
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->unsignedBigInteger('order_id')->nullable(); // Foreign key added after orders table exists
            
            // Enrollment Info
            $table->enum('enrollment_type', ['paid', 'free', 'gifted', 'coupon', 'admin', 'bundle', 'subscription'])->default('paid');
            $table->decimal('price_paid', 10, 2)->default(0.00);
            $table->string('currency', 3)->default('USD');
            
            // Access
            $table->timestamp('enrolled_at');
            $table->timestamp('expires_at')->nullable(); // For limited access courses
            $table->boolean('is_active')->default(true);
            
            // Progress
            $table->decimal('progress_percentage', 5, 2)->default(0.00);
            $table->integer('completed_lessons')->default(0);
            $table->integer('total_lessons')->default(0);
            $table->timestamp('last_accessed_at')->nullable();
            $table->foreignId('last_lesson_id')->nullable()->constrained('lessons')->onDelete('set null');
            $table->timestamp('completed_at')->nullable();
            $table->integer('total_watch_time')->default(0); // in seconds
            
            // Status
            $table->enum('status', ['active', 'completed', 'expired', 'refunded', 'suspended'])->default('active');
            $table->text('notes')->nullable();
            
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['user_id', 'course_id']);
            $table->index(['course_id', 'status']);
            $table->index(['user_id', 'status']);
            $table->index(['enrolled_at']);
        });

        // Lesson Progress (individual lesson tracking)
        Schema::create('lesson_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->foreignId('enrollment_id')->constrained('enrollments')->onDelete('cascade');
            
            // Progress
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->integer('watch_time')->default(0); // in seconds
            $table->integer('last_position')->default(0); // Resume position in seconds
            $table->decimal('progress_percentage', 5, 2)->default(0.00);
            $table->integer('views_count')->default(1);
            $table->timestamp('last_watched_at')->nullable();
            
            $table->json('notes')->nullable(); // Student notes
            $table->timestamps();

            $table->unique(['user_id', 'lesson_id']);
            $table->index(['enrollment_id', 'is_completed']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_progress');
        Schema::dropIfExists('enrollments');
    }
};
