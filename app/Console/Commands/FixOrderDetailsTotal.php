<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;

class FixOrderDetailsTotal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:order-details-total';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix order details total calculation for existing records';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting to fix order details total...');
        
        // Get all order details where total is 0 or null
        $orderDetails = OrderDetail::where(function($query) {
            $query->where('total', 0)
                  ->orWhereNull('total');
        })->get();
        
        $this->info("Found {$orderDetails->count()} order details to fix.");
        
        $fixed = 0;
        
        foreach ($orderDetails as $detail) {
            $correctTotal = $detail->quantity * $detail->price;
            
            $detail->update(['total' => $correctTotal]);
            
            $this->line("Fixed OrderDetail ID {$detail->id}: {$detail->quantity} x {$detail->price} = {$correctTotal}");
            $fixed++;
        }
        
        $this->info("Successfully fixed {$fixed} order details.");
        
        // Verify the fix
        $remainingZeros = OrderDetail::where('total', 0)->count();
        
        if ($remainingZeros == 0) {
            $this->info('✅ All order details now have correct totals!');
        } else {
            $this->warn("⚠️  Still {$remainingZeros} order details with zero total.");
        }
        
        return Command::SUCCESS;
    }
}
