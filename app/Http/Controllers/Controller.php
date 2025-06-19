<?php

namespace App\Http\Controllers;
use Twilio\Rest\Client;
use Aws\S3\S3Client;

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

      public function uploadS3($imagePath, $folder = "all")
    {

        $awsAccessKeyId = env("AWS_ACCESS_KEY_ID");
        $awsSecretAccessKey = env("AWS_SECRET_ACCESS_KEY");
        $awsRegion = env("AWS_DEFAULT_REGION");
        $awsBucket = env("AWS_BUCKET");
        // Create an S3 client
        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => $awsRegion,
            'credentials' => [
                'key' => $awsAccessKeyId,
                'secret' => $awsSecretAccessKey,
            ],
        ]);
        // Upload the image to S3

        $objectKey = $folder . '/' . basename($imagePath);

        $result = $s3Client->putObject([
            'Bucket' => $awsBucket,
            'Key' => $objectKey,
            'SourceFile' => $imagePath,

        ]);

        $imageUrl = $result['ObjectURL'];
        return $imageUrl;
    }

}
