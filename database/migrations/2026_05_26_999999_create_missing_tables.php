<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // roles
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id('role_id');
                $table->string('role_name');
            });
            DB::table('roles')->insert([
                ['role_id' => 1, 'role_name' => 'Admin'],
                ['role_id' => 2, 'role_name' => 'Customer'],
            ]);
        }

        // images
        if (!Schema::hasTable('images')) {
            Schema::create('images', function (Blueprint $table) {
                $table->id('image_id');
                $table->unsignedBigInteger('product_id');
                $table->string('image_url');
                $table->boolean('is_primary')->default(false);
            });
        }

        // addresses
        if (!Schema::hasTable('addresses')) {
            Schema::create('addresses', function (Blueprint $table) {
                $table->id('address_id');
                $table->unsignedBigInteger('user_id');
                $table->string('recipient_name');
                $table->string('phone_number', 20)->nullable();
                $table->string('address_line');
                $table->string('postcode', 10)->nullable();
                $table->string('state', 100)->nullable();
                $table->boolean('is_default')->default(false);
            });
        }

        // orders
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id('order_id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('address_id')->nullable();
                $table->timestamp('order_date')->useCurrent();
                $table->decimal('total_amount', 10, 2)->default(0);
                $table->enum('order_status', ['Pending','Processing','Packed','Shipped','Delivered','Cancelled'])->default('Pending');
            });
        }

        // order_items
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id('item_id');
                $table->unsignedBigInteger('order_id');
                $table->unsignedBigInteger('variant_id');
                $table->integer('quantity');
                $table->decimal('price_at_purchase', 10, 2);
                $table->decimal('subtotal', 10, 2);
            });
        }

        // payments
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id('payment_id');
                $table->unsignedBigInteger('order_id');
                $table->string('payment_method')->nullable();
                $table->enum('payment_status', ['Pending','Verified','Rejected'])->default('Pending');
                $table->decimal('amount', 10, 2)->default(0);
                $table->string('transaction_reference')->nullable();
                $table->timestamp('payment_date')->nullable();
            });
        }

        // history (order history)
        if (!Schema::hasTable('history')) {
            Schema::create('history', function (Blueprint $table) {
                $table->id('history_id');
                $table->unsignedBigInteger('order_id');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('status');
                $table->text('note')->nullable();
                $table->timestamp('updated_at')->useCurrent();
            });
        }

        // log (stock log)
        if (!Schema::hasTable('log')) {
            Schema::create('log', function (Blueprint $table) {
                $table->id('log_id');
                $table->unsignedBigInteger('variant_id');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('change_type');
                $table->integer('quantity_changed');
                $table->timestamp('log_date')->useCurrent();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('log');
        Schema::dropIfExists('history');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('images');
        Schema::dropIfExists('roles');
    }
};