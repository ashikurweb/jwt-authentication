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
        // Certificate Templates
        Schema::create('certificate_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('orientation')->default('landscape'); // landscape, portrait
            $table->string('size')->default('A4'); // A4, Letter, etc.
            $table->string('background_image')->nullable();
            $table->string('background_color')->default('#ffffff');
            $table->longText('html_content')->nullable(); // HTML template with placeholders
            $table->json('styles')->nullable(); // CSS styles
            $table->json('elements')->nullable(); // Dynamic elements positioning
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Issued Certificates
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('certificate_number')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('enrollment_id')->constrained('enrollments')->onDelete('cascade');
            $table->foreignId('template_id')->nullable()->constrained('certificate_templates')->onDelete('set null');
            
            // Certificate Details
            $table->string('student_name');
            $table->string('course_title');
            $table->string('instructor_name')->nullable();
            $table->date('completion_date');
            $table->date('issue_date');
            $table->date('expiry_date')->nullable(); // For certifications that expire
            
            // Verification
            $table->string('verification_url')->nullable();
            $table->string('qr_code')->nullable();
            
            // Files
            $table->string('pdf_path')->nullable();
            $table->string('image_path')->nullable();
            
            // Statistics
            $table->decimal('course_duration_hours', 8, 2)->nullable();
            $table->decimal('final_score', 5, 2)->nullable();
            $table->string('grade')->nullable(); // A, B, C or Pass/Distinction
            
            $table->boolean('is_valid')->default(true);
            $table->text('notes')->nullable();
            
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['user_id', 'course_id']);
            $table->index(['certificate_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('certificate_templates');
    }
};
