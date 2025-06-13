<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stripe as ModelsStripe;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Product;
use Stripe\Price;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Subscription;

class StripeController extends Controller
{
    public function plan()
    {
        return view('create');
    }

    public function subscribe(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated.'], JsonResponse::HTTP_UNAUTHORIZED);
            }

            Stripe::setApiKey(env('STRIPE_SECRET'));

            // 1. Create Product dynamically
            $product = Product::create([
                'name' => 'Your Product Name',   // or get from $request
                'description' => 'Description here',  // optional
            ]);

            // 2. Create Price (plan) for the product
            $price = Price::create([
                'unit_amount' => 1000, // amount in cents (e.g. $10.00)
                'currency' => 'usd',
                'recurring' => ['interval' => 'month'], // billing interval: day, week, month, year
                'product' => $product->id,
            ]);

            // 3. Create Stripe customer (if not exists or new)
            $customer = Customer::create([
                'email' => $user->email,
                'payment_method' => $request->payment_method,
                'invoice_settings' => [
                    'default_payment_method' => $request->payment_method,
                ],
            ]);

            // 4. Create subscription with the created price id
            $subscription = Subscription::create([
                'customer' => $customer->id,
                'items' => [
                    ['price' => $price->id],
                ],
                'expand' => ['latest_invoice.payment_intent'],
            ]);

            // Save subscription info in your DB
            $subscribe = new ModelsStripe();
            $subscribe->subscription_id = $subscription->id;
            $subscribe->user_id = $user->id;
            $subscribe->plain_id = $price->id;
            $subscribe->stripe_customer_id = $customer->id;
            $subscribe->status = $subscription->status;
            $subscribe->save();

            DB::commit();

            return response()->json(['success' => true, 'redirect_url' => route('subscribe')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
