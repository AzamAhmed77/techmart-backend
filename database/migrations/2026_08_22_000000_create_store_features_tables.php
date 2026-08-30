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
        // 1. User Addresses Table
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title')->default('المنزل'); // Home, Work, etc.
            $table->string('recipient_name');
            $table->string('phone');
            $table->string('city');
            $table->string('street');
            $table->string('details')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        // 2. Coupons Table
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->integer('discount_percentage')->default(10);
            $table->decimal('max_discount_amount', 10, 2)->nullable();
            $table->decimal('min_order_amount', 10, 2)->default(0);
            $table->dateTime('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Orders Table
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('shipping_fee', 10, 2)->default(15.00);
            $table->decimal('total', 10, 2);
            $table->string('payment_method')->default('cod'); // cod, card, mada, apple_pay
            $table->string('payment_status')->default('unpaid'); // unpaid, paid
            $table->string('recipient_name');
            $table->string('phone');
            $table->text('shipping_address');
            $table->string('city');
            $table->string('coupon_code')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 4. Order Items Table
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->string('product_name');
            $table->string('product_image')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(1);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });

        // 5. Product Reviews Table
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->unsignedTinyInteger('rating')->default(5); // 1-5
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'product_id']);
        });

        // 6. In-App Notifications Table
        Schema::create('in_app_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('order'); // order, promo, general
            $table->string('action_id')->nullable(); // order_id, product_id, etc.
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('in_app_notifications');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('user_addresses');
    }
};
