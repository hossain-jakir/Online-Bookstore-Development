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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('author_id')->constrained('users')->onUpdate('cascade')->onDelete('restrict');
            $table->string('isbn')->unique();
            $table->string('edition_language');
            $table->date('publication_date');
            $table->string('publisher');
            $table->integer('pages')->nullable();
            $table->integer('lessons')->nullable();
            $table->string('tags')->nullable();
            $table->decimal('rating', 2, 1)->nullable()->default(0);
            $table->integer('min_age')->nullable();

            $table->integer('quantity')->default(0);
            $table->decimal('purchase_price', 8, 2)->default(0);
            $table->decimal('sell_price', 8, 2)->default(0);
            $table->decimal('discounted_price', 8, 2)->nullable()->default(0);
            $table->enum('discount_type', ['fixed', 'percentage'])->nullable();

            $table->string('image')->nullable();
            $table->tinyInteger('availability')->default(0);
            $table->tinyInteger('featured')->default(0);
            $table->tinyInteger('on_sale')->default(0);
            $table->tinyInteger('free_delivery')->default(0);
            $table->enum('status', ['draft', 'published', 'archived'])->default('Draft');
            $table->enum('isDeleted', ['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
