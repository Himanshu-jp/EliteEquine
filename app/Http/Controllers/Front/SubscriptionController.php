<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\SubscriptionAddOnPlan;
use App\Models\TransactionAddon;
use App\Jobs\EmailSendJob;

use App\Services\Front\SubscriptionService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Product;
use Stripe\Price;
use Stripe\Subscription;

use Stripe\Checkout\Session as StripeSession;

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
 $addon=SubscriptionAddOnPlan::all();
        // dd($subscription->toArray());
        return view('frontauth/subscription', compact('subscription','addon'));
    }

    public function purchase_plan(request $request, $id)
    {
        if(Auth::user()->is_subscribed == '1' && Auth::user()->plan_expired_on != ' ' && Auth::user()->plan_expired_on != null){
        return redirect()->route('subscription')->with('error', 'Please cancel your existing plan.');

        }
        $planId = base64_decode($id);

        $planData = SubscriptionPlan::where('id', $planId)->first();

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkoutSession = StripeSession::create([
            'mode' => 'subscription',
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price' => $planData->price_id,
                    'quantity' => 1,
                ]
            ],
            'customer_email' => Auth::user()->email, // optional
            'metadata' => [
                'plan_id' => $planData->id, // Your hidden ID
                'user_id' => Auth::id(),    // Optional
            ],
            'success_url' => route('plan_purchase.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('plan_purchase.cancel'),
        ]);
        return redirect()->to($checkoutSession->url);

    }

    public function purchase_plan_success(request $request)
    {
    $mainUseData = ['FirstName'=>Auth::user()->name];

           $data=array('code'=>'payment','email'=>Auth::user()->email,'dataArray'=>$mainUseData,'name'=>Auth::user()->name);
                EmailSendJob::dispatch($data);


        $sessionId = $request->get('session_id');

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::retrieve($sessionId);

        // Optionally expand to get subscription & customer details
          $session = StripeSession::retrieve([
            'id' => $sessionId,
            'expand' => ['subscription', 'customer', 'payment_intent'],
        ]);


if(isset($session->metadata->type) && $session->metadata->type == 'charge-addons'){


        $plan_trans = new Transaction();
        $plan_trans->type = 'addon_id';
        $plan_trans->user_id = $session->metadata->user_id;
        $plan_trans->session_id = $session->id;
        $plan_trans->plan_purchase_on = time();
        $plan_trans->customer_id = $session->metadata->user_id;
        $plan_trans->plan_price = $session->amount_total / 100;
        $plan_trans->payment_status = $session->payment_status;
        $plan_trans->response_data = json_encode($session);
        $plan_trans->status = 'Paid';
        $plan_trans->save();

        $addon_data=explode(',',$session->metadata->addon_ids);
        foreach($addon_data as $add_ids){

TransactionAddon::insert(['user_id'=>$plan_trans->user_id,'transaction_id'=>$plan_trans->id,'addon_id'=>$add_ids,'add_on_data'=>json_encode(SubscriptionAddOnPlan::where('id',$add_ids)->first())]);
        }
        return redirect()->route('subscription')->with('success', 'Addon Added successfully.');
}else{
    $subscriptionData = $session->subscription->items->data[0];


        User::where('id', $session->metadata->user_id)->update(['is_subscribed' => 1, 'plan_expired_on' => $subscriptionData->current_period_end, 'plan_activated_on' => $subscriptionData->current_period_start, 'plan_id' => $session->metadata->plan_id, 'subscription_id' => $session->subscription->id]);


        $plan_trans = new Transaction();
        $plan_trans->type = 'plan';
        $plan_trans->plan_id = $session->metadata->plan_id;
        $plan_trans->user_id = $session->metadata->user_id;
        $plan_trans->session_id = $session->id;
        $plan_trans->plan_purchase_on = $subscriptionData->current_period_start;
        $plan_trans->next_renewal_date = $subscriptionData->current_period_end;
        $plan_trans->expired_on = $subscriptionData->current_period_end;
        $plan_trans->customer_id = $session->metadata->user_id;
        $plan_trans->plan_price = $session->amount_total / 100;
        $plan_trans->payment_status = $session->payment_status;
        $plan_trans->subscription_id = $session->subscription->id;
        $plan_trans->response_data = json_encode($session);
        $plan_trans->status = $session->subscription->status;
        $plan_trans->save();

        return redirect()->route('subscription')->with('success', 'Plan activated successfully.');
}
        



    }


    public function purchase_plan_cancel(request $request)
    {
        return redirect()->route('subscription')->with('error', 'Something went wrong.');
    }

    public function cancel_subscription()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $subscriptionId = Auth::user()->subscription_id; // your actual subscription ID
        $subscription = \Stripe\Subscription::retrieve($subscriptionId);
        $subscription->cancel(); // Cancels immediately


       

                $plan_trans = Transaction::where('subscription_id',$subscription->id)->update(['cancelled'=>$subscription->canceled_at]);
     
                 User::where('id', Auth::user()->id)->update(['is_subscribed' => 0, 'plan_expired_on' => null, 'plan_activated_on' => null, 'plan_id' => null, 'subscription_id' => null]);


        return redirect()->route('subscription')->with('success', 'Your subcription has been cancelled.');

    }
}
