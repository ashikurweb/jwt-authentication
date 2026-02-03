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
        // Wishlists
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->boolean('price_alert')->default(false); // Notify on price drop
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
            $table->index(['course_id']);
        });

        // Bookmarks (For lessons within enrolled courses)
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            
            $table->string('title')->nullable();
            $table->text('note')->nullable();
            $table->integer('timestamp')->nullable(); // Video timestamp in seconds
            
            $table->timestamps();

            $table->index(['user_id', 'course_id']);
        });

        // Notes (Student notes while watching)
        Schema::create('student_notes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            
            $table->text('content');
            $table->integer('timestamp')->nullable(); // Video timestamp
            $table->string('color')->default('yellow'); // Note highlight color
            
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'course_id']);
            $table->index(['lesson_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_notes');
        Schema::dropIfExists('bookmarks');
        Schema::dropIfExists('wishlists');
    }
};
