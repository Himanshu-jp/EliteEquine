<?php

namespace App\Services\Front;

use App\Models\Order;
use App\Models\UserAddress;
use App\Models\Product;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Mail\OrderSuccessBuyerMail;
use App\Mail\OrderSuccessOwnerMail;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Checkout\Session;
Stripe::setApiKey(env('STRIPE_SECRET')); 

class CheckoutService
{
    public function process(array $data, $product, $userId, $service_date, $time_slot_from, $time_slot_to)
    {
        $user = User::find($userId);
        if($service_date == '')
        {
            // $order = UserAddress::create([
            //     'user_id' => auth()->id(),
            //     'shipping_name' => @$data['shipping_name'],
            //     'shipping_phone' => @$data['shipping_phone'],
            //     'shipping_address' => @$data['shipping_address'],
            //     'shipping_city' => @$data['shipping_city'],
            //     'shipping_state' => @$data['shipping_state'],
            //     'shipping_zip' => @$data['shipping_zip'],
            //     'billing_name' => @$data['billing_name'],
            //     'billing_phone' => @$data['billing_phone'],
            //     'billing_address' => @$data['billing_address'],
            //     'billing_city' => @$data['billing_city'],
            //     'billing_state' => @$data['billing_state'],
            //     'billing_zip' => @$data['billing_zip'],
            //     'status' => 'pending',
            // ]);
            
        } else {
            $schedule = Schedule::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'service_date' => $service_date,
                'time_slot_from' => $time_slot_from,
                'time_slot_to' => $time_slot_to,
                'status' => '0'
            ]);
        }

        try {
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => $product->currency ?? 'usd',
                        'product_data' => [
                            'name' => $product->title, // ✅ only 'name' is allowed
                        ],
                        'unit_amount' => (int) ($product->price * 100), // amount in cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('product.success') . '?session_id={CHECKOUT_SESSION_ID}&product_id=' . $product->id,
                'cancel_url' => route('product.cancel') . '?session_id={CHECKOUT_SESSION_ID}&product_id=' . $product->id,
                'metadata' => [ 
                    'winner_id' => auth()->id(),
                    'product_id' => $product->id,
                ],
            ]);

            return [
                'success' => true, 
                'message' => 'success',
                'url' => $session->url,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false, 
                'message' => 'Unable to create payment session: ' . $e->getMessage(),
                'url' => '',
            ];
        }            
    }

    public function success($sessionId, $productId, $user)
    {
        $session = Session::retrieve($sessionId);
    
        // Optional: fetch related payment intent
        $paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent);
 
        //--------Store the data into the db--------///
        $product = Product::where(['id'=>$productId])
                ->whereNull('deleted_at')
                ->first();
        if(empty($product))
        {
            return [
                'success' => false,
                'data' => [],
                'message' => 'This product does not exist.'
            ];
        }

        if($product->category_id != 4)
        {
            $product->update(['product_status' => 'sold']);
        } else {
            $selectedDate = Schedule::where(['product_id' => @$product->id, 'user_id' => auth()->id(), 'status' => '0'])->orderBy('id', 'desc')->first();
            if(!empty($selectedDate))
            {
                $selectedDate->update(['status' => '1']);
            }
        }

        $data= [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'price' => $product->price,
            'currency' => $product->currency ?? 'usd',
            'stripe_session_id' => $session->id,
            'stripe_payment_intent' => $session->payment_intent,
            'payment_status' => $paymentIntent->status
        ];

        $order = Order::create($data);

        $buyer = $user;
        $owner = $product->user; 

        // Send mail to buyer
        Mail::to($buyer->email)->send(new OrderSuccessBuyerMail($order, $product));

        // Send mail to owner
        Mail::to($owner->email)->send(new OrderSuccessOwnerMail($order, $product));

        return [
            'success' => true,
            'data' => $order,
            'message' => 'Product has been successfully ordered.'
        ];
    }
}
