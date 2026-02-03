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
        // Affiliate System
        Schema::create('affiliates', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('affiliate_code')->unique();
            $table->string('referral_link')->nullable();
            
            // Commission Settings
            $table->decimal('commission_rate', 5, 2)->default(20.00); // Percentage
            $table->integer('cookie_days')->default(30); // Cookie lifetime
            
            // Statistics
            $table->integer('total_clicks')->default(0);
            $table->integer('total_referrals')->default(0);
            $table->integer('total_conversions')->default(0);
            $table->decimal('total_earnings', 15, 2)->default(0);
            $table->decimal('pending_earnings', 15, 2)->default(0);
            $table->decimal('paid_earnings', 15, 2)->default(0);
            
            // Status
            $table->enum('status', ['pending', 'approved', 'suspended', 'rejected'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            
            // Payment Info
            $table->string('payment_method')->nullable(); // paypal, bank, etc.
            $table->json('payment_details')->nullable();
            $table->decimal('minimum_payout', 10, 2)->default(50.00);
            
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['affiliate_code']);
            $table->index(['user_id', 'status']);
        });

        // Affiliate Referrals
        Schema::create('affiliate_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained('affiliates')->onDelete('cascade');
            $table->foreignId('referred_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('landing_page')->nullable();
            
            $table->enum('status', ['clicked', 'registered', 'converted', 'expired'])->default('clicked');
            
            $table->decimal('order_amount', 10, 2)->default(0);
            $table->decimal('commission_amount', 10, 2)->default(0);
            $table->decimal('commission_rate', 5, 2);
            
            $table->timestamp('clicked_at');
            $table->timestamp('registered_at')->nullable();
            $table->timestamp('converted_at')->nullable();
            $table->timestamp('expires_at');
            
            $table->timestamps();

            $table->index(['affiliate_id', 'status']);
            $table->index(['referred_user_id']);
        });

        // Affiliate Payouts
        Schema::create('affiliate_payouts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('affiliate_id')->constrained('affiliates')->onDelete('cascade');
            
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            
            $table->string('payment_method');
            $table->json('payment_details')->nullable();
            $table->string('transaction_id')->nullable();
            
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled'])->default('pending');
            
            $table->text('notes')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('processed_at')->nullable();
            
            $table->timestamps();

            $table->index(['affiliate_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_payouts');
        Schema::dropIfExists('affiliate_referrals');
        Schema::dropIfExists('affiliates');
    }
};
