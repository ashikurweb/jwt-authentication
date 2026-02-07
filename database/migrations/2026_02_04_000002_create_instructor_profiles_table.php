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
        // Instructor Profiles
        Schema::create('instructor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('headline')->nullable(); // e.g., "Senior Web Developer & Instructor"
            $table->text('bio')->nullable();
            $table->text('short_bio')->nullable();
            $table->string('expertise')->nullable(); // JSON array or comma-separated
            $table->string('website')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('github')->nullable();
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('total_reviews')->default(0);
            $table->integer('total_students')->default(0);
            $table->integer('total_courses')->default(0);
            $table->decimal('commission_rate', 5, 2)->default(70.00); // Instructor gets 70%
            $table->decimal('total_earnings', 15, 2)->default(0.00);
            $table->decimal('pending_earnings', 15, 2)->default(0.00);
            $table->enum('status', ['pending', 'approved', 'rejected', 'suspended'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->json('certifications')->nullable();
            $table->json('achievements')->nullable();
            $table->json('meta')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index(['is_featured', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_profiles');
    }
};
