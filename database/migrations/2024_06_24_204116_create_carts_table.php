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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->uniqid()->nullable()->default(null);
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['session_id', 'user_id']);

            $table->integer('total_quantity')->default(0);
            $table->integer('total_unique_items')->default(0);

            $table->string('coupon_code')->nullable()->default(null);
            $table->float('coupon_discount')->default(0);

            $table->foreignId('delivery_fee_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');

            $table->boolean('isCheckedOut')->default(false);
            $table->enum('status', ['active', 'inactive', 'completed'])->default('Active');
            $table->enum('isDeleted', ['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
