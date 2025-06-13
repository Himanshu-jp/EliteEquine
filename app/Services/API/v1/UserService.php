<?php
namespace App\Services\API\v1;

use App\Models\User;
use App\Models\UserDetails;
use App\Models\UserDetailAlert;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\API\v1\user\LoginResource;
use App\Http\Resources\API\v1\user\ProfileResource;
use App\Http\Resources\API\v1\user\SettingResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Mail\ForgotPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\Customer;
use Config;

class UserService
{
    public function login(array $credentials, string $deviceName): array
    {
        if (!Auth::attempt($credentials)) {
            return [
                'success' => false,
                'message' => 'Invalid credentials',
                'code' => 401
            ];
        }

        if (!Auth::attempt($credentials)) {
            return [
                'success' => false,
                'message' => 'Invalid credentials',
                'code' => 401
            ];
        }

        $user = Auth::guard('sanctum')->user();

        if (is_null($user->email_verified_at)) {
            return [
                'success' => false,
                'message' => 'Email address is not verified.',
                'code' => 403
            ];
        }

        $token = $user->createToken($deviceName)->plainTextToken;
        $user->token = $token;

        $data = new LoginResource($user);

        return [
            'success' => true,
            'data' => $data,
        ];
    }

    public function profile()
    {
        if (!Auth::guard('sanctum')->check()) {
            return [
                'success' => false,
                'message' => 'Invalid credentials',
                'code' => 401
            ];
        }

        $user = Auth::guard('sanctum')->user();

        $data = new ProfileResource($user);

        return [
            'success' => true,
            'data' => $data,
        ];
    }

    public function updateProfile(array $data): array
    {
        if (!Auth::guard('sanctum')->check()) {
            return [
                'success' => false,
                'message' => 'Invalid credentials',
                'code' => 401
            ];
        }

        $user = Auth::guard('sanctum')->user();

        if (isset($data['profile_photo_path'])) {
            if ($user->profile_photo_path) {
                Storage::delete($user->profile_photo_path);
            }
            $path = $data['profile_photo_path']->store('users', 'public');
            $data['profile_photo_path'] = $path;
        }

        $user->update($data);

        $data =  new ProfileResource($user);
        return [
            'success' => true,
            'data' => $data,
        ];
    }

    public function settingDetail()
    {
        if (!Auth::guard('sanctum')->check()) {
            return [
                'success' => false,
                'message' => 'Invalid credentials',
                'code' => 401
            ];
        }

        $user = Auth::guard('sanctum')->user();
        $userDetail = new SettingResource($user->getUserDetail);

        return [
            'success' => true,
            'data' => $userDetail,
        ];
    }

    public function settingUpdate($data): array
    {
        if (!Auth::guard('sanctum')->check()) {
            return [
                'success' => false,
                'message' => 'Invalid credentials',
                'code' => 401
            ];
        }

        $user = Auth::guard('sanctum')->user();
        
        // customer create on stripe
        Stripe::setApiKey(Config::get('config.stripe_secret'));
        // stripe custome update on stripe
        $customer = Customer::update($user->customer_id, array_filter([
            'phone' => $data['phone'],
        ]));

        $userDetail = $user->getUserDetail;
        $data['is_hide_phone'] = (@$data['is_hide_phone']) ? 1 : 0;

        if($userDetail){
            @$userDetail->update($data);
        }else{
            $data['user_id'] = $user->id;
            $owner = UserDetails::create($data);
        }

        $alerts = ['subscription', 'payment', 'auction'];
        foreach ($alerts as $metaKey) {
            $alertData = json_decode($data[$metaKey], true) ?? [];
            UserDetailAlert::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'user_detail_id' => $userDetail->id,
                    'meta_key' => $metaKey,
                ],
                [
                    'email'  => !empty($alertData['email']) ? 1 : 0,
                    'sms'    => !empty($alertData['sms']) ? 1 : 0,
                    'mobile' => !empty($alertData['mobile']) ? 1 : 0,
                ]
            );
        }

        $userDetail = new SettingResource($userDetail);

        return [
            'success' => true,
            'data' => $userDetail,
        ];
    }

    public function changePassword($data)
    {
        if (!Auth::guard('sanctum')->check()) {
            return [
                'success' => false,
                'message' => 'Invalid credentials',
                'code' => 401
            ];
        }

        $user = Auth::guard('sanctum')->user();
        if (!Hash::check($data['old_password'], $user->password)) {
            return [
                'success' => false,
                'message' => 'The current password is incorrect.',
                'code' => 422,
            ];
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        return [
            'success' => true,
            'data' => [],
        ];
    }

    public function forgotPassword(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        // If user not found, return null to handle gracefully in controller
        if (!$user) {
            return [
                'success' => false,
                'message' => 'This email address does not exist.',
                'code' => 404
            ];
        }

        // Delete existing password reset tokens
        DB::table('password_reset_tokens')
            ->where('email', $data['email'])
            ->delete();

        // Generate and insert new token
        $token = Str::random(64);
        DB::table('password_reset_tokens')->insert([
            'email' => $data['email'],
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // Prepare and send reset email
        $mailData = [
            'user_name' => $user->name ?? $user->email,
            'type' => encrypt('app'),
            'token' => $token,
        ];

        Mail::to($data['email'])->send(new ForgotPassword($mailData));

        return [
            'success' => true,
            'data' => $user,
        ];
    }

    public function logout()
    {
        if (!Auth::guard('sanctum')->check()) {
            return [
                'success' => false,
                'message' => 'Invalid credentials',
                'code' => 401
            ];
        }

        $user = Auth::guard('sanctum')->user();

        return [
            'success' => true,
            'data' => $user,
        ];
    }
}
