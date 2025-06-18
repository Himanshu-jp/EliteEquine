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
use App\Models\UserDetails;
use App\Models\UserDetailAlert;
use App\Jobs\EmailSendJob;


class CronController extends Controller
{

    public function cronFirst(request $request,$id){

        // sms
        // email
        // mobile

$myGraphs=['auction','listMatch', 'biddinItem', 'subscription', 'payment'];

$usergraphArray=[];
foreach($myGraphs as $graphName){
$usergraphArray[$graphName]=UserDetailAlert::where('meta_key',$graphName)->where($id,'1')->pluck('user_id')->toArray();
}
//For Subscription
 $getUser=User::where('is_subscribed','1')->whereIn('id',$usergraphArray['subscription'] ?? [])->get();
foreach($getUser as $users){
$expired= $users->plan_expired_on;
$alertTime= $users->plan_expired_on - 86400;

if($alertTime == time()){
Self::emailAddJob('SubscriptionExpiringSoon',$users->email);
}
}
// JOb Data

    }
  
    public function emailAddJob($code,$email){

           $data=array('code'=>$code,'email'=>$email);
                EmailSendJob::dispatch($data);
    }
}
