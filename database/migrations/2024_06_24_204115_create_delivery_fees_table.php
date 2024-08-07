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
        Schema::create('delivery_fees', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->text('description')->nullable();
            $table->tinyInteger('default')->default(0);

            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('isDeleted', ['yes', 'no'])->default('no');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_fees');
    }
};
