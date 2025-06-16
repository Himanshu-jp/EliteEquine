<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\UserDetails;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles, SoftDeletes;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'username',
        'stripe_id',
        'stripe_connect_data',
        'email',
        'password',
        'role',
        'opt_in_notification',
        'sms_notification',
        'mail_notification',
        'mobile_notification',
        'two_factor_secret',
        'phone_no',
        'bio',
        'country',
        'state',
        'city',
        'street',
        'social_type',
        'social_id',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'remember_token',
        'current_team_id',
        'profile_photo_path',
        'email_verified_at',
        'is_online',
        'socket_id',
        'customer_id',
        'payment_method_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationship: Get user detail.
     */
    public function getUserDetail()
    {
        return $this->hasOne(UserDetails::class, 'user_id');
    }

    public function enquiries()
    {
        return $this->hasMany(ContactUs::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'user_id');
    }
    
    public function order()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function chatuser()
    {
        return $this->hasOne(ChatUser::class, 'user_id');
    }

    
    public function userAddress()
    {
        return $this->hasMany(UserAddress::class, 'user_id');
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_owner_id');
    }
}
