<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\WinnerMail;
use App\Mail\OwnerMail;
use Log;

class UpdateExpiredProductBids extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-expired-product-bids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update product_status to "expire" if bid_expire_date is today or earlier';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        // Get all live products that expired
        $expiredProducts = Product::with('productBids')->where('product_status', 'live')
            ->whereDate('bid_expire_date', '<', $today)
            ->get();

        foreach ($expiredProducts as $product) {
            // Set status to expire
            $product->product_status = 'closed';
            $product->save();

            // Get highest bid
            $winningBid = $product->productBids()->first();

            if ($winningBid) {
                $winner = $winningBid->user;
                $owner = $product->user; 

                // Send email to the winner
                Mail::to($winner->email)->send(new WinnerMail($winner, $product, $owner));

                // Send email to the owner
                Mail::to($owner->email)->send(new OwnerMail($owner, $product, $winner));
            }

            Log::info("Product ID {$product->id} expired and notifications sent.");
        }

        Log::info("Processed " . $expiredProducts->count() . " expired products.");
    }
}
