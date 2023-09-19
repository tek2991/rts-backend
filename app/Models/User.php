<?php

namespace App\Models;

use App;
use Laravel\Sanctum\HasApiTokens;
use App\Actions\Functions\SendSMS;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
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
        'device_status',
        'device_status_updated_at',
        'lat',
        'lng',
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
        'device_status' => AsCollection::class,
        'device_status_updated_at' => 'datetime',
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
        SendSMS::sendOTP($this->mobile_number, $otp);
        $this->otp = $otp;
        $this->save();
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

    public function hasPendingMobileNumberVerification()
    {
        if(is_null($this->mobile_number_verified_at) && !is_null($this->otp)) {
            return true;
        }

        return false;
    }

    public function hasVerifiedMobileNumber()
    {
        if(is_null($this->mobile_number_verified_at)) {
            return false;
        }

        return $this->mobile_number_verified_at->lte(now());
    }

    public function hasVerifiedEmail()
    {
        if(is_null($this->email_verified_at)) {
            return false;
        }

        return $this->email_verified_at->lte(now());
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

        $latest_subscription = $this->subscriptions()->where('status', 'paid')->orderBy('expires_at', 'desc')->get();

        if($latest_subscription->count() < 1) {
            return false;
        }

        $latest_subscription = $latest_subscription->first();

        if($current_date < $latest_subscription->expires_at) {
            return $latest_subscription->expires_at->format('Y-m-d');
        }

        return false;
    }

    public function formattedDeviceStatus()
    {
        $device_status = $this->device_status;

        if(is_null($device_status)) {
            return null;
        }

        $device_status_updated_at = $this->device_status_updated_at->diffForHumans();

        $formatted_device_status = $device_status['brand'] . " " . $device_status['model'] . " | V-" . $device_status['android-version']. " | Bat-" . $device_status['battery'] . "% | " . $device_status_updated_at;

        return $formatted_device_status;
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function recordings()
    {
        return $this->hasMany(Recording::class);
    }

    public function screenRecordings()
    {
        return $this->hasMany(ScreenRecording::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
