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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 16, 2)->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('total', 16, 2)->change();
            $table->decimal('shipping_cost', 16, 2)->change();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('amount', 16, 2)->change();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('price', 16, 2)->change();
            $table->decimal('subtotal', 16, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('total', 12, 2)->change();
            $table->decimal('shipping_cost', 12, 2)->change();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('amount', 12, 2)->change();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->change();
            $table->decimal('subtotal', 12, 2)->change();
        });
    }
};
