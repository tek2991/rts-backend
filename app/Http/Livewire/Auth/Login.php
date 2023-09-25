<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;

class Login extends Component
{
    public $useEmail = false;

    public $email;
    public $password;
    public $remember;
    public $phone;
    public $otpSent = false;
    public $otpResent = false;
    public $otp;

    public function emailLogin()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $authenticated = auth()->attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remember);

        if ($authenticated) {
            return redirect()->intended(route('dashboard'));
        } else {
            // Add email validation error
            $this->addError('email', 'Invalid credentials.');
        }
    }

    public function sendOTP()
    {
        $this->validate([
            'phone' => 'required|digits:10',
        ]);

        $user = User::where('mobile_number', $this->phone)->first();

        if ($user) {
            $user->sendMobileNumberVerificationNotification();
            $this->otpSent = true;
        } else {
            $this->addError('phone', 'Phone number not found.');
        }
    }

    public function resendOTP()
    {
        $this->otpResent = true;
        $this->sendOTP();
    }

    public function verifyOTP()
    {
        $this->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = User::where('mobile_number', $this->phone)->first();

        if ($user->verifyMobileNumber($this->otp)) {
            auth()->login($user, $this->remember);
            return redirect()->intended(route('dashboard'));
        } else {
            $this->addError('otp', 'Invalid OTP.');
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
