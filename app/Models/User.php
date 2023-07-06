<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile_number',
        'device_id',
        'device_token',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_number_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function sendMobileNumberVerificationNotification()
    {
        $otp = rand(100000, 999999);
        $this->otp = $otp;
        $this->save();
        return $otp;
    }

    public function verifyMobileNumber($otp)
    {
        if ($this->otp == $otp) {
            $this->mobile_number_verified_at = now();
            $this->otp = null;
            $this->save();
            return true;
        }
        return false;
    }

    public function hasVerifiedMobileNumber()
    {
        return !is_null($this->mobile_number_verified_at);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activationCodes()
    {
        return $this->hasMany(ActivationCode::class);
    }

    public function hasActiveSubscription()
    {
        if($this->subscriptions()->count() < 1) {
            return false;
        }

        // Check if any subscription is active
        $current_date = now();
        $active_subscription = $this->subscriptions()->where('expires_at', '>', $current_date)->where('started_at', '<', $current_date)->where('status', 'paid')->first();

        if($active_subscription) {
            return true;
        }

        return false;
    }

    public function subscribedUpto()
    {
        $current_date = now();
        if($this->subscriptions()->count() < 1) {
            return false;
        }
        $latest_subscription = $this->subscriptions()->orderBy('expires_at', 'desc')->first();

        if($current_date < $latest_subscription->expires_at) {
            return $latest_subscription->expires_at;
        }

        return false;
    }
}
