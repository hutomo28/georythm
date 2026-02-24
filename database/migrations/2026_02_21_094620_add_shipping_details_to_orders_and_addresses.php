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
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('shipping_cost', 12, 2)->default(0)->after('total');
            $table->integer('distance_km')->default(0)->after('shipping_cost');
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->integer('distance_km')->default(0)->after('zip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_cost', 'distance_km']);
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('distance_km');
        });
    }
};
