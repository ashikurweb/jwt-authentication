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
        // Instructor Payouts
        Schema::create('instructor_payouts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            
            // Period covered
            $table->date('period_start');
            $table->date('period_end');
            
            // Breakdown
            $table->integer('total_orders')->default(0);
            $table->decimal('gross_amount', 10, 2)->default(0);
            $table->decimal('platform_fee', 10, 2)->default(0);
            $table->decimal('tax_withheld', 10, 2)->default(0);
            $table->decimal('net_amount', 10, 2)->default(0);
            
            // Payment
            $table->string('payment_method')->nullable();
            $table->json('payment_details')->nullable();
            $table->string('transaction_id')->nullable();
            
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled'])->default('pending');
            
            $table->text('notes')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('processed_at')->nullable();
            
            $table->timestamps();

            $table->index(['instructor_id', 'status']);
            $table->index(['period_start', 'period_end']);
        });

        // Instructor Earnings (Detailed per order/course)
        Schema::create('instructor_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('order_item_id')->constrained('order_items')->onDelete('cascade');
            
            $table->decimal('order_amount', 10, 2);
            $table->decimal('commission_rate', 5, 2); // Instructor's percentage
            $table->decimal('instructor_amount', 10, 2);
            $table->decimal('platform_amount', 10, 2);
            
            $table->foreignId('payout_id')->nullable()->constrained('instructor_payouts')->onDelete('set null');
            $table->enum('status', ['pending', 'cleared', 'paid', 'refunded'])->default('pending');
            
            $table->timestamps();

            $table->index(['instructor_id', 'status']);
            $table->index(['payout_id']);
        });

        // Instructor Payout Methods
        Schema::create('payout_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->enum('type', ['paypal', 'bank_transfer', 'stripe', 'wise', 'payoneer'])->default('paypal');
            $table->string('name'); // Account name/label
            
            // PayPal
            $table->string('paypal_email')->nullable();
            
            // Bank Transfer
            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_routing_number')->nullable();
            $table->string('bank_swift_code')->nullable();
            $table->string('bank_iban')->nullable();
            $table->string('bank_country')->nullable();
            
            // Other details
            $table->json('details')->nullable();
            
            $table->boolean('is_default')->default(false);
            $table->boolean('is_verified')->default(false);
            
            $table->timestamps();

            $table->index(['user_id', 'is_default']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout_methods');
        Schema::dropIfExists('instructor_earnings');
        Schema::dropIfExists('instructor_payouts');
    }
};
