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
        // Course Sections (Chapters/Modules)
        Schema::create('course_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->integer('duration_minutes')->default(0);
            
            // Drip Settings
            $table->boolean('drip_enabled')->default(false);
            $table->enum('drip_type', ['days_after_enrollment', 'date', 'after_section'])->nullable();
            $table->integer('drip_days')->nullable();
            $table->date('drip_date')->nullable();
            $table->foreignId('drip_after_section_id')->nullable()->constrained('course_sections')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();

            $table->index(['course_id', 'order']);
        });

        // Lessons (Lectures)
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('course_sections')->onDelete('cascade');
            
            $table->string('title');
            $table->text('description')->nullable();
            $table->longText('content')->nullable(); // For text lessons
            $table->integer('order')->default(0);
            
            // Lesson Type
            $table->enum('type', [
                'video',
                'text',
                'audio',
                'document',
                'quiz',
                'assignment',
                'live_class',
                'embed',
                'scorm'
            ])->default('video');
            
            // Video Settings
            $table->string('video_url')->nullable();
            $table->string('video_provider')->nullable(); // youtube, vimeo, upload, bunny, etc.
            $table->string('video_id')->nullable();
            $table->integer('duration_seconds')->default(0);
            $table->string('video_thumbnail')->nullable();
            $table->json('video_qualities')->nullable(); // Available quality options
            
            // Audio Settings
            $table->string('audio_url')->nullable();
            $table->integer('audio_duration')->nullable();
            
            // Document Settings
            $table->string('document_url')->nullable();
            $table->string('document_type')->nullable(); // pdf, ppt, word, etc.
            
            // Embed Settings
            $table->text('embed_code')->nullable();
            
            // Settings
            $table->boolean('is_free')->default(false); // Free preview
            $table->boolean('is_published')->default(true);
            $table->boolean('is_downloadable')->default(false);
            $table->boolean('is_prerequisite')->default(false);
            $table->boolean('is_locked')->default(false);
            
            // Drip Settings
            $table->boolean('drip_enabled')->default(false);
            $table->enum('drip_type', ['days_after_enrollment', 'date', 'after_lesson'])->nullable();
            $table->integer('drip_days')->nullable();
            $table->date('drip_date')->nullable();
            $table->foreignId('drip_after_lesson_id')->nullable()->constrained('lessons')->onDelete('set null');
            
            // Statistics
            $table->integer('total_views')->default(0);
            $table->integer('total_completions')->default(0);
            
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['course_id', 'section_id', 'order']);
            $table->index(['type', 'is_published']);
        });

        // Lesson Resources (Downloadable files)
        Schema::create('lesson_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type')->nullable(); // pdf, zip, etc.
            $table->integer('file_size')->default(0); // in bytes
            $table->boolean('is_downloadable')->default(true);
            $table->integer('order')->default(0);
            $table->integer('download_count')->default(0);
            $table->timestamps();

            $table->index(['lesson_id', 'order']);
        });

        // Video Tracks (Subtitles/Captions)
        Schema::create('video_tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->string('language', 10);
            $table->string('label'); // e.g., "English", "বাংলা"
            $table->string('file_path');
            $table->enum('kind', ['subtitles', 'captions', 'descriptions'])->default('subtitles');
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index(['lesson_id', 'language']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_tracks');
        Schema::dropIfExists('lesson_resources');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('course_sections');
    }
};
