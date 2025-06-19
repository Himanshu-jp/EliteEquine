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
use Mail,Log,Crypt;

class CronController extends Controller
{

    public function cronFirst(request $request,$id){



    
$myGraphs=['auction','listMatch', 'biddinItem', 'subscription', 'payment'];

$usergraphArray=[];
foreach($myGraphs as $graphName){
$usergraphArray[$graphName]=UserDetailAlert::where('meta_key',$graphName)->where($id,'1')->pluck('user_id')->toArray();
}



$getUser=User::where('is_subscribed','1')->whereIn('id',$usergraphArray['subscription'] ?? [])->get();
foreach($getUser as $users){
$expired= $users->plan_expired_on;
$alertTime= $users->plan_expired_on - 86400;
if($alertTime == time()){

    $mainUseData = ['Date' => date('d F,Y H:i',$expired),'UserName'=>$users->name];
Self::emailAddJob('SubscriptionExpiringSoon',$users->email,$mainUseData,$users->name);

//  $this->sendSms('918005829740','Hello');

}

}
    }
  
    public function emailAddJob($code,$email,$dataArray,$name){

        
           $data=array('code'=>$code,'email'=>$email,'dataArray'=>$dataArray,'name'=>$name);
                EmailSendJob::dispatch($data);
    }
}
