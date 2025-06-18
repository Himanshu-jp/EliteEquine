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

                   $data=array('code'=>$code,'email'=>$email);
                EmailSendJob::dispatch($data);

        $main_data = $this->data;

      

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


   
}
