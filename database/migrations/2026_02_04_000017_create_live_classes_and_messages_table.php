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
        // Live Classes / Webinars
        Schema::create('live_classes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade');
            $table->foreignId('lesson_id')->nullable()->constrained('lessons')->onDelete('cascade');
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            
            // Schedule
            $table->timestamp('scheduled_at');
            $table->integer('duration_minutes')->default(60);
            $table->string('timezone')->default('UTC');
            
            // Meeting Details
            $table->enum('platform', ['zoom', 'google_meet', 'youtube_live', 'vimeo', 'custom'])->default('zoom');
            $table->string('meeting_id')->nullable();
            $table->string('meeting_password')->nullable();
            $table->string('meeting_url')->nullable();
            $table->string('host_url')->nullable(); // Start meeting URL
            $table->string('recording_url')->nullable();
            
            // Settings
            $table->boolean('is_free')->default(false);
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('max_attendees')->nullable();
            $table->boolean('enable_chat')->default(true);
            $table->boolean('enable_qa')->default(true);
            $table->boolean('enable_recording')->default(true);
            $table->boolean('enable_replay')->default(true);
            
            // Status
            $table->enum('status', ['scheduled', 'live', 'ended', 'cancelled'])->default('scheduled');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            
            // Statistics
            $table->integer('registered_count')->default(0);
            $table->integer('attended_count')->default(0);
            $table->integer('peak_viewers')->default(0);
            
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['course_id', 'scheduled_at']);
            $table->index(['instructor_id', 'status']);
        });

        // Live Class Registrations
        Schema::create('live_class_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('live_class_id')->constrained('live_classes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->boolean('attended')->default(false);
            $table->timestamp('joined_at')->nullable();
            $table->timestamp('left_at')->nullable();
            $table->integer('watch_time')->default(0); // seconds
            
            // Reminder sent
            $table->boolean('reminder_sent')->default(false);
            
            $table->timestamps();

            $table->unique(['live_class_id', 'user_id']);
        });

        // Messages (Direct messaging between students and instructors)
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            
            // Can be related to a course or general
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade');
            
            $table->string('subject')->nullable();
            $table->enum('type', ['direct', 'support', 'course_inquiry'])->default('direct');
            
            $table->timestamp('last_message_at')->nullable();
            $table->boolean('is_closed')->default(false);
            
            $table->timestamps();
            $table->softDeletes();

            $table->index(['course_id']);
        });

        // Conversation Participants
        Schema::create('conversation_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('conversations')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->timestamp('last_read_at')->nullable();
            $table->integer('unread_count')->default(0);
            $table->boolean('is_muted')->default(false);
            
            $table->timestamps();

            $table->unique(['conversation_id', 'user_id']);
        });

        // Messages
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('conversation_id')->constrained('conversations')->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            
            $table->longText('content');
            $table->json('attachments')->nullable();
            
            $table->timestamp('read_at')->nullable();
            $table->boolean('is_system_message')->default(false);
            
            $table->timestamps();
            $table->softDeletes();

            $table->index(['conversation_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversation_participants');
        Schema::dropIfExists('conversations');
        Schema::dropIfExists('live_class_registrations');
        Schema::dropIfExists('live_classes');
    }
};
