<?php

namespace App\Services\Admin;

use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Stripe\Stripe;
use Stripe\Product;
use Stripe\Price;
use Config;

class SubscriptionPlanService
{
    public function __construct()
    {
        Stripe::setApiKey(Config::get('config.stripe_secret'));
    }

    public function create(array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('subscription-plans', 'public');
        }
        
        // Limit to 300 characters

  $cleaned = strip_tags($data['description']);

// Trim to 300 characters
$trimmed = substr($cleaned, 0, 300);

// Find the last full stop within the trimmed text
$lastPeriod = strrpos($trimmed, '.');

if ($lastPeriod !== false) {
    // Cut at the last full stop
    $result = substr($trimmed, 0, $lastPeriod + 1);
} else {
    // If no period found, just use the trimmed version
    $result = $trimmed;
}
        // product create on stripe
        $product = Product::create([
            'name' => $data['title'],
            'description' => $result,
            'metadata' => ['type' => $data['type']],
            'image' => @$data['image']
        ]);

        $data['stripe_product_id'] = $product->id;

        //add price with 
        $price = Price::create([
            'unit_amount' => $data['price']*100,
            'currency' => 'USD',
            'recurring' => [
                            'interval' => 'day',
                            'interval_count' => (int) $data['days'], // e.g. 45
                        ],
            'product' => $product->id,
        ]);

        $data['price_id'] = $price->id;

        return SubscriptionPlan::create($data);
    }

    public function update(SubscriptionPlan $subscriptionPlan, $data)
    {
         $oldData = $subscriptionPlan;
     
        if (isset($data['image'])) {
            if ($subscriptionPlan->image) {
                Storage::disk('public')->delete($data['image']);
            }
            $data['image'] = $data['image']->store('subscription-plans', 'public');
        }

        // Limit to 300 characters
       $cleaned = strip_tags($data['description']);

// Trim to 300 characters
$trimmed = substr($cleaned, 0, 300);

// Find the last full stop within the trimmed text
$lastPeriod = strrpos($trimmed, '.');

if ($lastPeriod !== false) {
    // Cut at the last full stop
    $result = substr($trimmed, 0, $lastPeriod + 1);
} else {
    // If no period found, just use the trimmed version
    $result = $trimmed;
}

     if($oldData->price != $data['price']){
               $product = Product::create([
                'name' => $data['title'],
                'description' => $result,
                'metadata' => ['type' => $data['type']],
                'image' => @$data['image']
            ]);

            $data['stripe_product_id'] = $product->id;
      
            $price = Price::create([
                'unit_amount' => $data['price']*100,
                'currency' => 'USD',
                'recurring' => [
                                'interval' => 'day',
                                'interval_count' => (int) $data['days'], // e.g. 45
                            ],
                'product' => $product->id,
            ]);

            $data['price_id'] = $price->id;
        }else{
            $data['price_id'] = $oldData->price_id;
            $data['stripe_product_id'] = $oldData->stripe_product_id;

        }
  

        $subscriptionPlan->update($data);
        return $subscriptionPlan;
    }

    // Delete a subscription plan (soft delete)
    public function destroy($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);

        // stripe product delete
        $product = Product::update($plan->stripe_product_id, ['active' => false]);
        // stripe price delete
        $price = Price::update($plan->price_id, ['active' => false]);


        $plan->delete();
    }

    public function find($id)
    {
        return SubscriptionPlan::findOrFail($id);
    }

    // Restore a deleted subscription plan (soft delete)
    public function restore($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);

        // stripe product delete
        $product = Product::update($plan->stripe_product_id, ['active' => true]);
        // stripe price delete
        $price = Price::update($plan->price_id, ['active' => true]);

        $plan->restore();
    }

    public function all()
    {
        return SubscriptionPlan::orderBy('id', 'desc')->paginate(10);
    }
}
