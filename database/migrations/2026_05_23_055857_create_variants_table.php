<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id('variant_id');

            $table->unsignedBigInteger('product_id');

            $table->string('size');
            $table->string('colour');

            $table->integer('stock_qty')->default(0);

            $table->decimal('price', 10, 2)->nullable();

            $table->timestamps();

            $table->foreign('product_id')
                ->references('product_id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};