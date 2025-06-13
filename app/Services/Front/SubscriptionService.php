<?php

namespace App\Services\Front;

use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserDetailAlert;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Storage;

class SubscriptionService
{

    //---get all the subscription listing---//
    // public function getSubscription()
    // {
    //     $user = SubscriptionPlan::where('deleted_at', null)->get();
    //     return $user;
    // }

    
}
