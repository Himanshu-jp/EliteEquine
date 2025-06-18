<?php

namespace App\Jobs;

use Mail, DB, Crypt;
use App\Models\User;
use App\Models\NotificationModel;
use App\Models\RideStopages;
use App\Models\RideMembers;
use App\Models\Rides;
use App\Models\GroupMembers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Log;
use Google\Service\FirebaseCloudMessaging;
use Google\Client as C;
class EmailSendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $main_data = $this->data;

        if (isset($main_data) && $main_data['main_type'] == 'fcm') {

            $token = User::where('id', $main_data['id'])->first()->device_token;
            if (!empty($token)) {
                self::sendFcmNotfication($main_data['title'], $token, $main_data['message'],'invitation');
            }
        } else if (isset($main_data) && $main_data['main_type'] == 'crash') {

            $rideDetals = Rides::where('id', $main_data['ride_id'])->first();
            $rideMEmes = RideMembers::with('userData')->where('ride_id', $main_data['ride_id'])->get();
            $userDetails = User::where('id', $main_data['user_id'])->first();


            foreach ($rideMEmes as $members) {
                $token = $members->userData->device_token;
                if (!empty($token)) {
                    $title = '🚨 Member Crash Alert';
                    $message = $userDetails->full_name . ' may have been in a crash during their ride. Please check in or assist if nearby.';
                    self::sendFcmNotfication($title, $token, $message,'crash');
                }

            }

        } else if (isset($main_data) && $main_data['main_type'] == 'ride_end') {

            $rideDetals = Rides::where('id', $main_data['ride_id'])->first();
            $rideMEmes = RideMembers::with('userData')->where('ride_id', $main_data['ride_id'])->get();

            foreach ($rideMEmes as $members) {
                $token = $members->userData->device_token;
                if (!empty($token)) {

                    $title = '🎉 Ride Completed Successfully';
                    $message = 'Your ride  from ' . $rideDetals->start_location_name . ' to ' . $rideDetals->destination_location_name . ' has ended. Thank you for riding with Rider To The Rescue. See you again soon!';
                    self::sendFcmNotfication($title, $token, $message,'rider_end');
                }

            }

        } else if (isset($main_data) && $main_data['main_type'] == 'ride_start') {

            $rideDetals = Rides::where('id', $main_data['ride_id'])->first();
            $rideMEmes = RideMembers::with('userData')->where('ride_id', $main_data['ride_id'])->get();


            foreach ($rideMEmes as $members) {
                $token = $members->userData->device_token;
                if (!empty($token)) {

                    $title = '🛣️ Your Ride Has Started';
                    $message = 'Your ride from ' . $rideDetals->start_location_name . ' to ' . $rideDetals->destination_location_name . ' has started. Stay safe and enjoy the journey with Rider To The Rescue.';
                    self::sendFcmNotfication($title, $token, $message,'rider_start');
                }

            }

        } else if (isset($main_data) && $main_data['main_type'] == 'help_and_support') {
            $userDetails = User::where('id', $main_data['id'])->first();

            $rideDetals = Rides::where('id', $main_data['ride_id'])->first();
            $rideMEmes = RideMembers::with('userData')->where('user_id', '!=', $main_data['id'])->where('ride_id', $main_data['ride_id'])->get();

            foreach ($rideMEmes as $members) {
                $token = $members->userData->device_token;
                if (!empty($token)) {

                    $title = ' 🆘 Ride Help Request Alert';
                    $message = @$userDetails->full_name . '  has sent a HELP request in your ongoing ride.';
                    self::sendFcmNotfication($title, $token, $message,'helps');
                }

            }
        } else {


            $type = $main_data['type'];
            $useData = $main_data['mainUseData'];
            $email = $main_data['toEmail'];
            $name = $main_data['toName'];



            if ($email != '' && $email != null) {

                $mainDBDATA = DB::table('email_template')->where('email_type', $type)->first();
                $config = array('mail_email' => 'support@riderrescue.com', 'mail_from_name' => 'Rider Rescue');
                $content = $mainDBDATA->content;

                foreach ($useData as $mainKey => $mainVal) {
                    $content = str_replace('{{' . $mainKey . '}}', $mainVal, $content);

                }
                $data2 = array('content' => $content);
                $subject = $mainDBDATA->email_subject;
                Mail::send('emails.dynamic_mail', $data2, function ($message) use ($subject, $config, $name, $email) {
                    $message->to($email, $name)->subject($subject);
                    $message->from($config['mail_email'], $config['mail_from_name']);
                });
            }
        }



    }


    public function getAccessToken()
    {
        $client = new C();
        $client->setAuthConfig(public_path('riders-to-the-rescue-firebase-adminsdk-fbsvc-7833c92493.json'));
        $client->addScope(FirebaseCloudMessaging::CLOUD_PLATFORM);

        $token = $client->fetchAccessTokenWithAssertion();

        if (isset($token['access_token'])) {
            return $token['access_token'];
        } else {
            throw new Exception('Failed to obtain access token.');
        }
    }

    public function sendFcmNotfication($title = null, $device_token = null, $bodyMsg = null,$type=null)
    {
        try {
            if (!empty($device_token)) {
                $message = [
                    'title' => $title,
                    'body' => $bodyMsg
                ];
                $notificationData = [
                    "registration_ids" => is_array($device_token) ? $device_token : [$device_token],
                    "notification" => $message,
                    "data" => [
                        'id' => 1, //(int)$notification->notification_id,
                        'title' => 'Notification_title',
                        'description' => 'Notification_description',
                        'type' => $type,
                        'image' => '',
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    "priority" => "high",
                    'lang' => 'en',
                    "content_available" => true,
                    "mutable_content" => true,
                    "apns" => [
                        "payload" => [
                            "aps" => [
                                "sound" => "default",
                                "content-available" => 1
                            ]
                        ]
                    ],
                ];

                $curl = curl_init();

                $unique_tokens = array_unique($notificationData['registration_ids']);
                foreach ($unique_tokens as $token) {
                    $badge = 0;

                   $dataString = json_encode([
    'message' => [
        'token' => $token,
        'notification' => [
            'title' => $notificationData['notification']['title'],
            'body' => $notificationData['notification']['body'],
        ],
        'data' => array_merge(
            array_map('strval', $notificationData['data']),
            ['type' => 'app']
        ),
        'android' => [
            'priority' => 'high',
        ],
        'apns' => [
            'payload' => [
                'aps' => [
                    'badge' => $badge,
                ],
            ],
        ],
    ]
]);


                    $curl = curl_init();

                    $headers = [
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $this->getAccessToken()
                    ];

                    // Set cURL options
                    curl_setopt_array($curl, [
                        CURLOPT_URL => 'https://fcm.googleapis.com/v1/projects/riders-to-the-rescue/messages:send',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => $dataString,
                        CURLOPT_HTTPHEADER => $headers,
                    ]);

                    $response = curl_exec($curl); // Get the response here

                    curl_close($curl);
                }



                return true;
            } else {
                return 'token not found';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
