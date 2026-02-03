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
        // Course Reviews
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('enrollment_id')->constrained('enrollments')->onDelete('cascade');
            
            // Rating
            $table->decimal('rating', 2, 1); // 1.0 to 5.0
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            
            // Detailed Ratings
            $table->decimal('rating_content', 2, 1)->nullable();
            $table->decimal('rating_instructor', 2, 1)->nullable();
            $table->decimal('rating_value', 2, 1)->nullable();
            
            // Moderation
            $table->enum('status', ['pending', 'approved', 'rejected', 'flagged'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('moderated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('moderated_at')->nullable();
            
            // Engagement
            $table->integer('helpful_count')->default(0);
            $table->integer('not_helpful_count')->default(0);
            $table->integer('report_count')->default(0);
            
            // Instructor Response
            $table->text('instructor_response')->nullable();
            $table->timestamp('responded_at')->nullable();
            
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_verified_purchase')->default(true);
            
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['user_id', 'course_id']);
            $table->index(['course_id', 'status', 'rating']);
        });

        // Review Helpful Votes
        Schema::create('review_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained('reviews')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('vote', ['helpful', 'not_helpful']);
            $table->timestamps();

            $table->unique(['review_id', 'user_id']);
        });

        // Review Reports
        Schema::create('review_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained('reviews')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('reason');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'dismissed'])->default('pending');
            $table->timestamps();

            $table->index(['review_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_reports');
        Schema::dropIfExists('review_votes');
        Schema::dropIfExists('reviews');
    }
};
