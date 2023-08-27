<?php

namespace App\Actions\Functions;

use Livewire\Component;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class SendFcmNotification
{
    public static function send($device_token, $action_to = 'device_status', $title = null, $body = null)
    {
        $data = [
            'device_token' => $device_token,
            'title' => $title,
            'body' => $body,
            'action_to' => $action_to,
        ];

        // Send notification to device
        try {
            $message = CloudMessage::withTarget('token', $data['device_token'])
                ->withNotification(Notification::create($data['title'], $data['body']))
                ->withData(['action_to' => $data['action_to']]);

            $messaging = app('firebase.messaging');
            $messaging->send($message);

            $res = [
                'status' => true,
                'message' => 'Notification sent for: ' . $action_to . '!',
            ];
            return $res;
        } catch (\Throwable $th) {
            $res = [
                'status' => false,
                'message' => 'Failed to send ' . $action_to . ' notification! - ' . $th->getMessage(),
            ];
            return $res;
        }
    }
}
