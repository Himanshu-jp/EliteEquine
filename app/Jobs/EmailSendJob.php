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

            $code = $main_data['code'];
            $email = $main_data['email'];
            $name=$main_data['name'];

                $dataArray = $main_data['dataArray'];
       
            if ($email != '' && $email != null) {

                $mainDBDATA = DB::table('templates')->where('code', $code)->first();
                $config = array('mail_email' => 'support@elitequeen.com', 'mail_from_name' => 'Elite Queen');
                $content = $mainDBDATA->email_template;

                foreach ($dataArray as $mainKey => $mainVal) {
                    $content = str_replace('[' . $mainKey . ']', $mainVal, $content);

                }
                $data2 = array('content' => $content);
                $subject = $mainDBDATA->subject;
                Mail::send('emails.dynamic_mail', $data2, function ($message) use ($subject, $config, $name, $email) {
                    $message->to($email, $name)->subject($subject);
                    $message->from($config['mail_email'], $config['mail_from_name']);
                });

                
            }

       

    }


   
}
