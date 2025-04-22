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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('banner')->nullable();
            $table->integer('product_category_id')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->integer('price')->nullable();
            $table->integer('stock_quantity')->nullable();
            $table->integer('is_popular')->nullable();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
