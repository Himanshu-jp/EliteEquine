<?php

namespace App\Http\Controllers;
use Twilio\Rest\Client;
use DB;
abstract class Controller
{
      public function sendSms($number,$message)
    {
        try {
             $setting = DB::table('settings')->where('type',"twilio")->where("status",1)->first();

             $sid = decrypt($setting->twilio_asid);
            $token =decrypt($setting->twilio_auth_token);
            $TWILIO_MESSAGE_SENDER_ID = decrypt($setting->twilio_message);


            $twilio = new Client($sid, $token);
    
             $message = $twilio->messages
                ->create(
                    $number, // to
                    array(
                        "messagingServiceSid" => $TWILIO_MESSAGE_SENDER_ID,
                        "body" => $message,
                    )
                );
             $response = $message->sid;
    
            return response()->json(['message' => 'Something went wrong, please try again.', 'status' => 200, 'data' => $response], 200);
            // return $response;
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong, please try again.', 'status' => 500, 'data' => $e->getMessage()], 500);
            exit;
        }
    }

}
