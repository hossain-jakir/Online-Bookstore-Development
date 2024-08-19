<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\error;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paypals', function (Blueprint $table) {
            $table->id();
            $table->text('token')->nullable();
            $table->string('paypal_id')->unique();
            $table->text('payer_id')->nullable();
            $table->string('payer_first_name')->nullable();
            $table->string('payer_last_name')->nullable();
            $table->string('payer_email')->nullable();
            $table->string('status')->nullable();

            $table->string('amount')->nullable();
            $table->string('currency')->nullable();

            $table->string('paypal_fee')->nullable();
            $table->string('paypal_fee_currency')->nullable();

            $table->string('net_amount')->nullable();
            $table->string('net_amount_currency')->nullable();

            $table->text('payment_source')->nullable();
            $table->text('purchase_units')->nullable();
            $table->text('payer')->nullable();

            $table->text('error')->nullable();
            $table->text('error_message')->nullable();

            $table->text('refund_id')->nullable();
            $table->text('refund_status')->nullable();
            $table->text('refund_amount')->nullable();
            $table->text('refund_currency')->nullable();

            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
