<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class VerifyMobileNumber extends Component
{
    public $otpSent = false;
    public $otp = '';

    public function mount()
    {
        if(Auth::user()->hasPendingMobileNumberVerification()) {
            $this->otpSent = true;
        }
    }

    /**
     * Sent the otp.
     *
     * @return void
     */
    public function sendOTP()
    {
        Auth::user()->sendMobileNumberVerificationNotification();
        $this->otpSent = true;
    }

    public function submit()
    {
        $this->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        if (Auth::user()->verifyMobileNumber($this->otp)) {
            return redirect()->route('dashboard');
        } else {
            $this->addError('otp', 'Invalid OTP.');
            $this->otp = '';
        }
    }

    public function render()
    {
        return view('livewire.verify-mobile-number');
    }
}
