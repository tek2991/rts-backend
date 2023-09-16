<?php

namespace App\Actions\Functions;

use Livewire\Component;

class SendSMS
{
    public static function sendOTP($number, $otp)
    {
        // Account details
        $apiKey = urlencode(config('services.textlocal.api_key'));

        // Message details
        $numbers = array($number);
        $sender = urlencode(config('services.textlocal.sender'));
        $message = rawurlencode($otp . " is the OTP to login at RTS. Valid for 1 min only. RTS LLP");
        $numbers = implode(',', $numbers);

        // Prepare data for POST request
        $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
        if(config('services.textlocal.test_mode')) {
            $data['test'] = true;
        }

        // Send the POST request with cURL
        $ch = curl_init(config('services.textlocal.send_sms_url'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response, true);

        if ($response['status'] == 'success') {
            return true;
        } else {
            return false;
        }
    }
}
