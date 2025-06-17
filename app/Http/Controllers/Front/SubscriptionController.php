<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Services\Front\SubscriptionService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;



class SubscriptionController extends Controller
{
    protected $subscriptionService;
    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }


    public function index(Request $request)
    {
        $subscription = SubscriptionPlan::whereNull('deleted_at')
            ->get()
            ->groupBy('type');

        // dd($subscription->toArray());
        return view('frontauth/subscription', compact('subscription'));
    }

    public function purchase_plan(request $request,$id){
         $planId= base64_decode($id);

           $planData = SubscriptionPlan::where('id',$planId)->first();

           Stripe::setApiKey(env('STRIPE_SECRET'));

    $checkoutSession = Session::create([
        'mode' => 'subscription',
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price' => $planData->price_id,
            'quantity' => 1,
        ]],
        'customer_email' => $request->email, // optional
        'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('checkout.cancel'),
    ]);

    }
}
