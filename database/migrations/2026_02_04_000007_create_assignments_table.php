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
        // Assignments
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('lesson_id')->nullable()->constrained('lessons')->onDelete('cascade');
            
            $table->string('title');
            $table->longText('description')->nullable();
            $table->longText('instructions')->nullable();
            
            // Settings
            $table->integer('total_points')->default(100);
            $table->integer('passing_points')->default(50);
            $table->timestamp('due_date')->nullable();
            $table->boolean('allow_late_submission')->default(true);
            $table->integer('late_submission_penalty')->default(0); // percentage deduction
            $table->integer('max_file_size')->default(10); // MB
            $table->json('allowed_file_types')->nullable(); // ['pdf', 'doc', 'zip']
            $table->integer('max_submissions')->default(1);
            
            $table->boolean('is_required')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('order')->default(0);
            
            // Attachments (reference files from instructor)
            $table->json('attachments')->nullable();
            
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['course_id', 'is_published']);
        });

        // Assignment Submissions
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('enrollment_id')->constrained('enrollments')->onDelete('cascade');
            
            $table->integer('submission_number')->default(1);
            $table->longText('content')->nullable(); // Text submission
            $table->json('files')->nullable(); // Uploaded files
            
            // Grading
            $table->enum('status', ['draft', 'submitted', 'grading', 'graded', 'returned', 'resubmit'])->default('draft');
            $table->decimal('points_earned', 8, 2)->nullable();
            $table->boolean('is_late')->default(false);
            $table->integer('late_penalty_applied')->default(0);
            
            $table->longText('feedback')->nullable();
            $table->json('inline_comments')->nullable(); // Comments on specific parts
            $table->foreignId('graded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('graded_at')->nullable();
            
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['assignment_id', 'user_id']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
        Schema::dropIfExists('assignments');
    }
};
