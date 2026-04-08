<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CancelUnpaidOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cancel-unpaid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel orders that have been waiting for payment for more than 24 hours and restore stock';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = \Illuminate\Support\Carbon::now()->subHours(24);
        
        $orders = \App\Models\Order::where('status', 'waiting-payment')
            ->where('created_at', '<', $limit)
            ->with(['items.product', 'payment'])
            ->get();

        $count = 0;
        foreach ($orders as $order) {
            // Restore stock
            foreach ($order->items as $item) {
                if ($item->product) {
                    $sizeRecord = $item->product->sizes()->where('size', $item->size)->first();
                    if ($sizeRecord) {
                        $sizeRecord->increment('stock', $item->quantity);
                    } else {
                        $item->product->increment('stock', $item->quantity);
                    }
                }
            }

            $order->update(['status' => 'cancelled']);
            
            // Mark payment as failed if exists
            if ($order->payment) {
                 $order->payment->update(['status' => 'failed']);
            }

            $count++;
        }

        $this->info("Successfully cancelled {$count} unpaid orders older than 24 hours.");
    }
}
