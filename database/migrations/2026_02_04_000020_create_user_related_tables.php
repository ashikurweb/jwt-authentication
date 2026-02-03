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
        // User Profiles (Extended profile info)
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Personal Info
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cover_image')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other', 'prefer_not_to_say'])->nullable();
            
            // Bio
            $table->string('headline')->nullable();
            $table->text('bio')->nullable();
            
            // Location
            $table->string('country', 2)->nullable();
            $table->string('city')->nullable();
            $table->string('timezone')->nullable();
            $table->string('language', 5)->default('en');
            
            // Social Links
            $table->string('website')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('github')->nullable();
            $table->string('instagram')->nullable();
            
            // Professional
            $table->string('occupation')->nullable();
            $table->string('company')->nullable();
            $table->json('skills')->nullable();
            $table->json('interests')->nullable();
            
            // Learning Goals
            $table->json('learning_goals')->nullable();
            
            $table->boolean('profile_completed')->default(false);
            $table->json('meta')->nullable();
            
            $table->timestamps();

            $table->unique(['user_id']);
        });

        // Student Course Recommendations
        Schema::create('course_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            
            $table->decimal('score', 5, 2)->default(0); // Recommendation score
            $table->string('reason')->nullable(); // "Based on your interests", etc.
            $table->enum('type', ['personalized', 'trending', 'popular', 'similar', 'instructor'])->default('personalized');
            
            $table->boolean('is_dismissed')->default(false);
            
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
            $table->index(['user_id', 'is_dismissed', 'score']);
        });

        // Search History
        Schema::create('search_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('session_id')->nullable();
            
            $table->string('query');
            $table->integer('results_count')->default(0);
            $table->json('filters')->nullable();
            
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['query']);
        });

        // Watch History
        Schema::create('watch_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            
            $table->integer('last_position')->default(0); // seconds
            $table->integer('duration_watched')->default(0); // total seconds watched
            $table->decimal('progress_percentage', 5, 2)->default(0);
            
            $table->timestamp('last_watched_at');
            $table->timestamps();

            $table->unique(['user_id', 'lesson_id']);
            $table->index(['user_id', 'last_watched_at']);
        });

        // Course Prerequisites
        Schema::create('course_prerequisites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('prerequisite_course_id')->constrained('courses')->onDelete('cascade');
            $table->boolean('is_required')->default(false); // Must complete vs recommended
            $table->integer('order')->default(0);
            
            $table->timestamps();

            $table->unique(['course_id', 'prerequisite_course_id']);
        });

        // Related Courses
        Schema::create('related_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('related_course_id')->constrained('courses')->onDelete('cascade');
            $table->enum('relationship', ['similar', 'next_level', 'complementary'])->default('similar');
            $table->integer('order')->default(0);
            
            $table->timestamps();

            $table->unique(['course_id', 'related_course_id']);
        });

        // Instructor Withdrawal Requests
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            
            $table->foreignId('payout_method_id')->constrained('payout_methods')->onDelete('cascade');
            
            $table->enum('status', ['pending', 'approved', 'rejected', 'processing', 'completed'])->default('pending');
            
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            
            $table->string('transaction_id')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('processed_at')->nullable();
            
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
        Schema::dropIfExists('related_courses');
        Schema::dropIfExists('course_prerequisites');
        Schema::dropIfExists('watch_history');
        Schema::dropIfExists('search_history');
        Schema::dropIfExists('course_recommendations');
        Schema::dropIfExists('user_profiles');
    }
};
