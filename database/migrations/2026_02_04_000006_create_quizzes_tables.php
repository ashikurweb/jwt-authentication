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
        // Quizzes
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('lesson_id')->nullable()->constrained('lessons')->onDelete('cascade');
            
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('instructions')->nullable();
            
            // Settings
            $table->integer('time_limit')->nullable(); // in minutes, null = unlimited
            $table->integer('passing_score')->default(50); // percentage
            $table->integer('max_attempts')->default(0); // 0 = unlimited
            $table->boolean('show_answers_after_submission')->default(true);
            $table->boolean('show_correct_answers')->default(true);
            $table->boolean('randomize_questions')->default(false);
            $table->boolean('randomize_options')->default(false);
            $table->integer('questions_per_page')->default(1); // 0 = all on one page
            $table->boolean('allow_review')->default(true);
            $table->boolean('is_required')->default(false); // Must pass to continue
            $table->integer('total_points')->default(0);
            $table->integer('total_questions')->default(0);
            
            $table->boolean('is_published')->default(true);
            $table->integer('order')->default(0);
            
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['course_id', 'is_published']);
        });

        // Quiz Questions
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            
            $table->enum('type', [
                'single_choice',       // MCQ - single answer
                'multiple_choice',     // MCQ - multiple answers
                'true_false',
                'short_answer',
                'long_answer',
                'fill_blank',          // Fill in the blank
                'matching',            // Match pairs
                'ordering',            // Arrange in order
                'image_choice',        // Choose image
                'essay'
            ])->default('single_choice');
            
            $table->text('question');
            $table->text('explanation')->nullable(); // Shown after answering
            $table->string('image')->nullable();
            $table->string('audio')->nullable();
            $table->string('video')->nullable();
            
            $table->integer('points')->default(1);
            $table->integer('order')->default(0);
            $table->boolean('is_required')->default(false);
            
            // For fill_blank, short_answer (case sensitivity, etc.)
            $table->json('settings')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->index(['quiz_id', 'order']);
        });

        // Quiz Question Options (Answers)
        Schema::create('quiz_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('quiz_questions')->onDelete('cascade');
            
            $table->text('option_text');
            $table->string('image')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->text('feedback')->nullable(); // Shown if this option is selected
            $table->integer('order')->default(0);
            
            // For matching questions
            $table->string('match_with')->nullable();
            
            $table->timestamps();

            $table->index(['question_id', 'order']);
        });

        // Quiz Attempts
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->foreignId('enrollment_id')->constrained('enrollments')->onDelete('cascade');
            
            $table->integer('attempt_number')->default(1);
            $table->timestamp('started_at');
            $table->timestamp('submitted_at')->nullable();
            $table->integer('time_spent')->default(0); // in seconds
            
            $table->integer('total_questions')->default(0);
            $table->integer('answered_questions')->default(0);
            $table->integer('correct_answers')->default(0);
            $table->integer('wrong_answers')->default(0);
            $table->integer('skipped_questions')->default(0);
            
            $table->decimal('score_earned', 8, 2)->default(0);
            $table->decimal('score_total', 8, 2)->default(0);
            $table->decimal('percentage', 5, 2)->default(0);
            
            $table->boolean('is_passed')->default(false);
            $table->enum('status', ['in_progress', 'submitted', 'graded', 'expired'])->default('in_progress');
            
            $table->text('feedback')->nullable(); // Instructor feedback
            $table->foreignId('graded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('graded_at')->nullable();
            
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'quiz_id']);
            $table->index(['status']);
        });

        // Quiz Answers (User responses per question)
        Schema::create('quiz_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('quiz_attempts')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('quiz_questions')->onDelete('cascade');
            
            $table->json('selected_options')->nullable(); // For MCQ
            $table->text('text_answer')->nullable(); // For text-based questions
            $table->json('order_answer')->nullable(); // For ordering questions
            $table->json('matching_answer')->nullable(); // For matching questions
            
            $table->boolean('is_correct')->nullable();
            $table->decimal('points_earned', 8, 2)->default(0);
            $table->text('feedback')->nullable(); // Question-specific feedback
            
            $table->boolean('is_flagged')->default(false); // Student flagged for review
            $table->timestamps();

            $table->unique(['attempt_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_answers');
        Schema::dropIfExists('quiz_attempts');
        Schema::dropIfExists('quiz_options');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quizzes');
    }
};
