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
        // Shopping Cart
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('session_id')->nullable(); // For guest users
            $table->timestamps();

            $table->index(['user_id']);
            $table->index(['session_id']);
        });

        // Cart Items
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('carts')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->timestamps();

            $table->unique(['cart_id', 'course_id']);
        });

        // Coupons
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            
            // Discount Type
            $table->enum('type', ['percentage', 'fixed', 'free'])->default('percentage');
            $table->decimal('discount_value', 10, 2)->default(0);
            $table->decimal('max_discount', 10, 2)->nullable(); // For percentage coupons
            $table->decimal('min_order_value', 10, 2)->default(0);
            
            // Usage Limits
            $table->integer('usage_limit')->nullable(); // Total uses allowed
            $table->integer('per_user_limit')->default(1);
            $table->integer('used_count')->default(0);
            
            // Validity
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            
            // Restrictions
            $table->boolean('is_active')->default(true);
            $table->json('applicable_courses')->nullable(); // Specific course IDs
            $table->json('applicable_categories')->nullable();
            $table->json('excluded_courses')->nullable();
            $table->boolean('first_purchase_only')->default(false);
            
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['code', 'is_active']);
            $table->index(['expires_at', 'is_active']);
        });

        // Orders
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Pricing
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->string('currency', 3)->default('USD');
            
            // Coupon
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->onDelete('set null');
            $table->string('coupon_code')->nullable();
            
            // Status
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'failed',
                'cancelled',
                'refunded',
                'partially_refunded'
            ])->default('pending');
            
            // Payment
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable(); // stripe, paypal, etc.
            $table->string('payment_gateway')->nullable();
            $table->string('transaction_id')->nullable();
            $table->json('payment_details')->nullable();
            $table->timestamp('paid_at')->nullable();
            
            // Billing Info
            $table->string('billing_name')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_phone')->nullable();
            $table->text('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('billing_zip')->nullable();
            
            // Invoice
            $table->string('invoice_number')->nullable();
            $table->string('invoice_path')->nullable();
            
            $table->text('notes')->nullable();
            $table->json('meta')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index(['order_number']);
            $table->index(['payment_status']);
        });

        // Order Items
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            
            $table->string('course_title');
            $table->decimal('price', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('final_price', 10, 2);
            
            // For bundles
            $table->foreignId('bundle_id')->nullable();
            
            // Instructor payout tracking
            $table->decimal('instructor_share', 10, 2)->default(0);
            $table->decimal('platform_share', 10, 2)->default(0);
            
            $table->timestamps();

            $table->index(['order_id']);
            $table->index(['course_id']);
        });

        // Refunds
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            
            $table->text('reason');
            $table->enum('status', ['pending', 'approved', 'rejected', 'processed'])->default('pending');
            
            $table->string('transaction_id')->nullable();
            $table->text('admin_notes')->nullable();
            
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('processed_at')->nullable();
            
            $table->timestamps();

            $table->index(['order_id', 'status']);
        });

        // Coupon Usage Tracking
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coupon_id')->constrained('coupons')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->decimal('discount_amount', 10, 2);
            $table->timestamps();

            $table->index(['coupon_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_usages');
        Schema::dropIfExists('refunds');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
    }
};
