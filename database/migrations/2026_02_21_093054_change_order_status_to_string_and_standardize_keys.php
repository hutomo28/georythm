<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration 
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->change();
        });

        // Migrate data
        $mapping = [
            'menunggu-pembayaran' => 'waiting-payment',
            'sedang-dikemas' => 'processing',
            'sedang-dikirim' => 'shipped',
            'pesanan-tiba' => 'arrived',
            'selesai' => 'completed',
            'dibatalkan' => 'cancelled',
        ];

        foreach ($mapping as $old => $new) {
            DB::table('orders')->where('status', $old)->update(['status' => $new]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
        // Revert to enum would require knowing all possible values
        // For simplicity, just change back to enum if we really need to
        });
    }
};
