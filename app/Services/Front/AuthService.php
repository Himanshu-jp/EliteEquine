<?php

namespace App\Services\Front;

use App\Mail\ForgotPassword;
use App\Mail\PasswordChange;
use App\Mail\RegisterVerificaton;
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
use Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Stripe\Stripe;
use Stripe\Customer;

class AuthService
{

    //---register a new user---//
    public function register($data)
    {
        // customer create on stripe
        Stripe::setApiKey(Config::get('config.stripe_secret'));

        // Create customer on Stripe
        $customer = Customer::create([
            'email' => $data['email'],
            'name' => $data['name'],
        ]);
        
        $user = User::create([
            'name'     => $data['name'],
            'username' => $data['name'],
            'email'    => $data['email'],
            'role' => 2,
            'opt_in_notification' => $data['opt_in_notification'],
            'sms_notification' => @$data['sms'] ? 1 : 0,
            'mail_notification' => @$data['mail'] ? 1 : 0,
            'mobile_notification' => @$data['mobile'] ? 1 : 0,
            'password' => Hash::make($data['password']),
            'customer_id' => $customer->id
        ]);

        $user->assignRole('user');

        $userDetails = UserDetails::create([
            'user_id' => $user->id,
            'first_name' => $data['name'],
            'email' => $data['email'],
        ]);

        //kamal
        $notifiactionDetails = [];

     
        $alerts = ['subscription', 'payment', 'auction','listMatch','biddinItem'];
        foreach ($alerts as $metaKey) {
            // $alert = UserDetailAlert::where([
            //     'meta_key' => $metaKey,
            //     'user_id' => $user->id,
            //     'user_detail_id' => $owner->id
            // ])->first();

            // if ($alert) {
            //     $alert->email  = !empty($data[$metaKey]['email']) ? 1 : 0;
            //     $alert->sms    = !empty($data[$metaKey]['sms']) ? 1 : 0;
            //     $alert->mobile = !empty($data[$metaKey]['mobile']) ? 1 : 0;
            //     $alert->save();
            // }

            $notifiactionDetails[] = [
                'user_id' => $user->id,
                'user_detail_id' => $userDetails->id,
                'meta_key' => $metaKey,
                'sms' => !empty($data[$metaKey]['sms']) ? 1 : 0,
                'mobile' => !empty($data[$metaKey]['mobile']) ? 1 : 0,
                'email' => !empty($data[$metaKey]['email']) ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // $notifiactionDetails = [
        //     [
        //         'user_id' => $user->id,
        //         'user_detail_id' => $userDetails->id,
        //         'meta_key' => $metaKey,
        //         'sms' => !empty($data[$metaKey]['sms']) ? 1 : 0,
        //         'mobile' =>!empty($data[$metaKey]['mobile']) ? 1 : 0,
        //         'email' => !empty($data[$metaKey]['email']) ? 1 : 0,
        //         'created_at'=> (new DateTime())->format('Y-m-d H:i:s'),
        //         'updated_at'=> (new DateTime())->format('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'user_id' => $user->id,
        //         'user_detail_id' => $userDetails->id,
        //         'meta_key' => 'payment',
        //         'sms' => @$data['sms'] ? 1 : 0,
        //         'mobile' => @$data['mobile'] ? 1 : 0,
        //         'email' => @$data['mail'] ? 1 : 0,
        //         'created_at'=> (new DateTime())->format('Y-m-d H:i:s'),
        //         'updated_at'=> (new DateTime())->format('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'user_id' => $user->id,
        //         'user_detail_id' => $userDetails->id,
        //         'meta_key' => 'auction',
        //         'sms' => @$data['sms'] ? 1 : 0,
        //         'mobile' => @$data['mobile'] ? 1 : 0,
        //         'email' => @$data['mail'] ? 1 : 0,
        //         'created_at'=> (new DateTime())->format('Y-m-d H:i:s'),
        //         'updated_at'=> (new DateTime())->format('Y-m-d H:i:s'),
        //     ]
        // ];

        $userDetails = UserDetailAlert::insert($notifiactionDetails);

        $encryptedEmail = Crypt::encrypt($data['email']);
        $mailData = [
            'user_name' => $data['name'],
            'type' => @$data['type'] ? encrypt($data['type']) : null,
            'email' =>  $encryptedEmail,
        ];
        $result = Mail::to($data['email'])->send(new RegisterVerificaton($mailData));
    }

    //-----Verify new account email address-----// 
    public function verifyNewAccountService($token)
    {
        try {
            // Decrypt the data
            $decryptedData = Crypt::decrypt($token);
            $user = User::where('email', $decryptedData)->update(['email_verified_at' => new DateTime()]);
            return true;
        } catch (DecryptException $e) {
            return false;
        }
    }


    //---forgot password----//
    public function forgotPassword($data)
    {

        $userRole = User::where('email', $data['email'])->first();
        if (empty($userRole)) {
            return back()->with('error', 'This email address is not associated with this panel.!');
        }

        DB::table('password_reset_tokens')
            ->where([
                'email' => $data['email']
            ])
            ->delete();

        $token = Str::random(64);
        DB::table('password_reset_tokens')->insert([
            'email' => $data['email'],
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $mailData = [
            'user_name' => $data['email'],
            'token' => $token,
        ];
        $result = Mail::to($data['email'])->send(new ForgotPassword($mailData));
    }

    //-----check reset password token-----// 
    public function resetPasswordCheckToken($token)
    {
        $result = DB::table('password_reset_tokens')->where('token', $token)->first();
        return $result;
    }

    //---reset password----//
    public function resetPassword($data)
    {

        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'email' => $data['email'],
                'token' => $data['token']
            ])
            ->first();

        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid or expired token. Please try again.');
        }

        $user = User::where('email', $data['email'])
            ->update(['password' => Hash::make($data['password'])]);

        DB::table('password_reset_tokens')->where(['email' => $data['email']])->delete();
        $user =  User::where('email', $data['email'])->first();
        $mailData = [
            'user_name' => $user->name,
            'email' => $user->email
        ];
        Mail::to($data['email'])->send(new PasswordChange($mailData));
    }

    public function profileUpdate($data,$user)
    {
        $owner = User::where('id', $user->id)->first();

        if (isset($data['profile_photo_path'])) {
            // Delete old image if exists
            if ($owner->profile_photo_path && Storage::disk('public')->exists($owner->profile_photo_path)) {
                Storage::disk('public')->delete($owner->profile_photo_path);
            }
            // Store the new image and get the path
            $data['profile_photo_path'] = $data['profile_photo_path']->store('users', 'public');
        }
        $owner->update($data);
        return $owner;
    }

    public function changePassword($data,$user)
    {
        if (!Hash::check($data['old_password'], $user->password)) {
            return false;
        } else {
            $user->password = Hash::make($data['password']);
            $user->save();
            return true;
        }
    }


    public function settingUpdate($data,$user)
    {
        // customer create on stripe
        Stripe::setApiKey(Config::get('config.stripe_secret'));
        // stripe custome update on stripe
        if($user->customer_id!=""){
            
            $customer = Customer::update($user->customer_id, array_filter([
                'phone' => $data['phone'],
            ]));
        }
        
        $owner = UserDetails::where('user_id', $user->id)->first();
        $data['is_hide_phone'] = (@$data['is_hide_phone']) ? 1 : 0;
        if($owner){
            $owner->update($data);
        }else{
            $data['user_id'] = $user->id;
            $owner = UserDetails::create($data);
        }

         $alerts = ['subscription', 'payment', 'auction','listMatch','biddinItem'];

        foreach ($alerts as $metaKey) {
            $alert = UserDetailAlert::where([
                'meta_key' => $metaKey,
                'user_id' => $user->id,
                'user_detail_id' => $owner->id
            ])->first();

            if ($alert) {
                $alert->email  = !empty($data[$metaKey]['email']) ? 1 : 0;
                $alert->sms    = !empty($data[$metaKey]['sms']) ? 1 : 0;
                $alert->mobile = !empty($data[$metaKey]['mobile']) ? 1 : 0;
                $alert->save();
            }
        }
        return $owner;
    }
}
