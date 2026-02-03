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
        // Subscription Plans
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('badge_text')->nullable(); // e.g., "Most Popular"
            $table->string('badge_color')->nullable();
            
            // Pricing
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->enum('billing_period', ['monthly', 'quarterly', 'yearly', 'lifetime'])->default('monthly');
            $table->integer('billing_interval')->default(1); // e.g., 1 month, 3 months
            
            // Trial
            $table->boolean('has_trial')->default(false);
            $table->integer('trial_days')->default(0);
            
            // Features
            $table->json('features')->nullable(); // List of features
            $table->boolean('access_all_courses')->default(true);
            $table->json('included_categories')->nullable(); // Specific categories
            $table->json('excluded_courses')->nullable();
            $table->integer('max_courses')->nullable(); // null = unlimited
            $table->boolean('download_resources')->default(true);
            $table->boolean('certificates')->default(true);
            $table->boolean('priority_support')->default(false);
            
            // Limits
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            
            // Stripe/Payment Gateway IDs
            $table->string('stripe_product_id')->nullable();
            $table->string('stripe_price_id')->nullable();
            $table->string('paypal_plan_id')->nullable();
            
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'order']);
        });

        // User Subscriptions
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('subscription_plans')->onDelete('cascade');
            
            // Subscription Details
            $table->string('subscription_id')->nullable(); // External gateway subscription ID
            $table->enum('status', [
                'active',
                'trialing',
                'past_due',
                'paused',
                'cancelled',
                'expired'
            ])->default('active');
            
            // Billing
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('payment_method')->nullable();
            
            // Dates
            $table->timestamp('starts_at');
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('current_period_start')->nullable();
            $table->timestamp('current_period_end')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            
            // Cancellation
            $table->text('cancellation_reason')->nullable();
            $table->boolean('cancel_at_period_end')->default(false);
            
            // Payment Gateway Info
            $table->string('stripe_subscription_id')->nullable();
            $table->string('paypal_subscription_id')->nullable();
            
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index(['plan_id', 'status']);
        });

        // Subscription Invoices
        Schema::create('subscription_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('subscription_id')->constrained('subscriptions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->decimal('amount', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('currency', 3)->default('USD');
            
            $table->enum('status', ['draft', 'open', 'paid', 'void', 'uncollectible'])->default('open');
            
            $table->timestamp('billing_period_start');
            $table->timestamp('billing_period_end');
            $table->timestamp('due_date');
            $table->timestamp('paid_at')->nullable();
            
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('pdf_path')->nullable();
            
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['subscription_id', 'status']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_invoices');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('subscription_plans');
    }
};
