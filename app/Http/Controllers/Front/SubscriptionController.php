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
}
