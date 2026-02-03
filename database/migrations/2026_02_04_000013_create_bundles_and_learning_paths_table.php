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
        // Course Bundles
        Schema::create('bundles', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('cover_image')->nullable();
            
            // Pricing
            $table->decimal('price', 10, 2);
            $table->decimal('compare_price', 10, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            
            // Settings
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            
            // Statistics
            $table->integer('total_courses')->default(0);
            $table->integer('total_duration_hours')->default(0);
            $table->integer('total_enrollments')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['instructor_id', 'is_published']);
        });

        // Bundle Courses (Pivot)
        Schema::create('bundle_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bundle_id')->constrained('bundles')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->unique(['bundle_id', 'course_id']);
        });

        // Learning Paths (Sequential Course Collections)
        Schema::create('learning_paths', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('cover_image')->nullable();
            
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->integer('estimated_hours')->default(0);
            $table->string('skill_outcome')->nullable(); // e.g., "Full Stack Developer"
            
            $table->boolean('is_free')->default(false);
            $table->decimal('price', 10, 2)->default(0);
            $table->string('currency', 3)->default('USD');
            
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_sequential')->default(true); // Must complete in order
            
            $table->integer('total_enrollments')->default(0);
            $table->decimal('completion_rate', 5, 2)->default(0);
            
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_published', 'is_featured']);
        });

        // Learning Path Steps
        Schema::create('learning_path_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_path_id')->constrained('learning_paths')->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade');
            
            $table->string('title')->nullable(); // Custom title or use course title
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            
            $table->enum('type', ['course', 'milestone', 'quiz', 'project'])->default('course');
            $table->boolean('is_required')->default(true);
            $table->boolean('is_locked')->default(false); // Unlock after previous step
            
            $table->json('completion_requirements')->nullable(); // e.g., pass quiz with 80%
            
            $table->timestamps();

            $table->index(['learning_path_id', 'order']);
        });

        // Learning Path Enrollments
        Schema::create('learning_path_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('learning_path_id')->constrained('learning_paths')->onDelete('cascade');
            
            $table->decimal('progress_percentage', 5, 2)->default(0);
            $table->integer('completed_steps')->default(0);
            $table->foreignId('current_step_id')->nullable()->constrained('learning_path_steps')->onDelete('set null');
            
            $table->timestamp('enrolled_at');
            $table->timestamp('completed_at')->nullable();
            
            $table->enum('status', ['active', 'completed', 'paused'])->default('active');
            
            $table->timestamps();

            $table->unique(['user_id', 'learning_path_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_path_enrollments');
        Schema::dropIfExists('learning_path_steps');
        Schema::dropIfExists('learning_paths');
        Schema::dropIfExists('bundle_courses');
        Schema::dropIfExists('bundles');
    }
};
