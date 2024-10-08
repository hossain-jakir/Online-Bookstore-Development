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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('address_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('shipping_address_id')->constrained('addresses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('coupon_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('delivery_method_id')->nullable()->constrained('delivery_fees')->onUpdate('cascade')->onDelete('set null');

            $table->string('order_number')->unique();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('coupon_amount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('shipping_amount', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2);
            $table->decimal('paid_amount', 10, 2)->nullable()->default(0);
            $table->decimal('due_amount', 10, 2)->nullable()->default(0);
            $table->decimal('refund_amount', 10, 2)->nullable()->default(0);
            $table->decimal('profit_amount', 10, 2)->nullable()->default(0);

            $table->enum('payment_method', ['cod', 'card', 'paypal', 'stripe']);
            $table->string('payment_id')->nullable();
            $table->string('payment_status')->nullable();
            $table->timestamp('shipping_date')->nullable();
            $table->timestamp('delivery_date')->nullable();
            $table->enum('shipping_status', ['pending', 'processing', 'shipped', 'delivered', 'canceled'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('canceled_at')->nullable();

            $table->text('notes')->nullable();

            $table->enum('status', ['pending', 'processing', 'completed', 'declined', 'canceled','refunded'])->default('pending');
            $table->enum('isDeleted', ['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
