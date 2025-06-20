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
use Stripe\Account;
use Stripe\Subscription;
use App\Models\User;
use Log;

class StripeController extends Controller
{

    //stript Connect Code


    public function connect_stipe_account(request $request)
    {



        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $account = \Stripe\Account::create([
            'type' => 'custom',
            'country' => 'US',
            'email' => Auth::user()->email,
            'capabilities' => [
                'transfers' => ['requested' => true], // important
            ],
            'business_type' => 'individual',
            'individual' => [
                'first_name' => Auth::user()->name,
                'last_name' => ' ',
                'email' => Auth::user()->email,
            ],
            'tos_acceptance' => [
                'date' => time(),
                'ip' => $request->ip(),
            ],
        ]);

        User::where('id', Auth::user()->id)->update(['stripe_id' => $account->id]);
        $accountLink = \Stripe\AccountLink::create([
            'account' => $account->id,
            'refresh_url' => route('webhook_stripe_for_connect') . '?account_id=' . $account->id,
            'return_url' => route('webhook_stripe_for_connect') . '?account_id=' . $account->id,
            'type' => 'account_onboarding',
        ]);

        return redirect()->to($accountLink->url);


        //   return   __transferAmount('acct_1RaWyjQciskEp7bw',50);
        //     $user= Auth::user();
        // $url = 'https://connect.stripe.com/oauth/authorize?' . http_build_query([
        //     'response_type' => 'code',
        //     'client_id' => 'ca_SVWxo5o959YJTBWMiRyBbcRPz12qR4UD', // Live Client ID
        //     'scope' => 'read_write',
        //     'state' =>$user->id ,
        // ]);

        // return redirect($url);
    }

public function updateAccountDetails(request $request){
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    $accountId=Auth::user()->stripe_id;
        $accountLink = \Stripe\AccountLink::create([
            'account' => $accountId,
            'refresh_url' => route('webhook_stripe_for_connect') . '?account_id=' . $accountId,
            'return_url' => route('webhook_stripe_for_connect') . '?account_id=' . $accountId,
            'type' => 'account_onboarding',
        ]);

        return redirect()->to($accountLink->url);
}


    public function webhook_stripe_for_connect(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $connectedAccountId = $request->account_id;
        $bankAccounts = \Stripe\Account::allExternalAccounts(
            $connectedAccountId, // e.g. "acct_1ABC23XYZ..."
            [
                'object' => 'bank_account',
            ]
        );

        User::where('stripe_id', $connectedAccountId)->update(['stripe_connect_data' => json_encode($bankAccounts['data'])]);

        //     $ch = curl_init();
        //     curl_setopt($ch, CURLOPT_URL, "https://connect.stripe.com/oauth/token");
        //     curl_setopt($ch, CURLOPT_POST, 1);
        //     curl_setopt(
        //         $ch,
        //         CURLOPT_POSTFIELDS,
        //         "client_secret=" . env('STRIPE_SECRET', env('STRIPE_SECRET')) . "&grant_type=authorization_code&code=" . $request->code . ""
        //     );

        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //      $server_output = curl_exec($ch);

        //     curl_close($ch);
        //     if(!is_array($server_output)){
        //         $server_output = json_decode($server_output, true);
        //     }
        //     return $server_output;
        //     $user_id= $_GET['state'] ?? Auth::user()->id;

        //      $user_data =User::where('id',$user_id)->first();
        //     $user_data->stripe_id = isset($server_output['stripe_user_id']) ? $server_output['stripe_user_id'] : '';
        // $user_data->stripe_connect_data = json_encode($server_output ?? []);
        //     $user_data->save();
        return redirect()->route('settings')->with('Success', 'Stripe account setup successfully');
    }

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

    public function stripewebhook(request $request){
        Log::info(json_encode($request->all()));
    }
}
