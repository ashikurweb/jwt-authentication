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
        // Q&A / Discussion Forums
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('lesson_id')->nullable()->constrained('lessons')->onDelete('cascade');
            
            $table->string('title');
            $table->longText('content');
            
            // Type
            $table->enum('type', ['question', 'discussion', 'announcement'])->default('question');
            
            // Status
            $table->enum('status', ['open', 'answered', 'closed', 'flagged'])->default('open');
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_featured')->default(false);
            
            // Best Answer (for Q&A)
            $table->foreignId('best_answer_id')->nullable();
            
            // Engagement
            $table->integer('views_count')->default(0);
            $table->integer('replies_count')->default(0);
            $table->integer('upvotes_count')->default(0);
            $table->integer('followers_count')->default(0);
            
            $table->timestamp('last_activity_at')->nullable();
            
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['course_id', 'status', 'type']);
            $table->index(['lesson_id', 'type']);
            $table->index(['user_id', 'status']);
        });

        // Discussion Replies
        Schema::create('discussion_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discussion_id')->constrained('discussions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('discussion_replies')->onDelete('cascade');
            
            $table->longText('content');
            
            $table->boolean('is_best_answer')->default(false);
            $table->boolean('is_instructor_reply')->default(false);
            
            $table->integer('upvotes_count')->default(0);
            $table->integer('replies_count')->default(0);
            
            $table->enum('status', ['active', 'flagged', 'deleted'])->default('active');
            
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['discussion_id', 'status']);
            $table->index(['parent_id']);
        });

        // Discussion Upvotes
        Schema::create('discussion_upvotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->morphs('upvoteable'); // discussion or reply
            $table->timestamps();

            $table->unique(['user_id', 'upvoteable_id', 'upvoteable_type']);
        });

        // Discussion Followers (get notified of updates)
        Schema::create('discussion_followers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discussion_id')->constrained('discussions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['discussion_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussion_followers');
        Schema::dropIfExists('discussion_upvotes');
        Schema::dropIfExists('discussion_replies');
        Schema::dropIfExists('discussions');
    }
};
