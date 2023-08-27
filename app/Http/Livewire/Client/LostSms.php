<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;
use App\Actions\Functions\SendFcmNotification;

class LostSms extends Component
{
    public function sendNotification($action_to)
    {
        // If device token is empty
        if (empty(auth()->user()->device_token)) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'No Device token! Please register your device first',
            ]);
            return;
        }

        $data = [
            'device_token' => auth()->user()->device_token,
            'title' => null,
            'body' => null,
            'action_to' => $action_to,
        ];

        // Send notification to device
        try {
            $res = SendFcmNotification::send($data['device_token'], $data['action_to'], $data['title'], $data['body']);
            $this->dispatchBrowserEvent('banner-message', [
                'style' => $res['status'] ? 'success' : 'danger',
                'message' => $res['message'],
            ]);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'Failed to send ' . $action_to . ' notification! - ' . $th->getMessage(),
            ]);
        }
    }

    public function lostMessage()
    {
        $this->sendNotification('lost_message');
    }

    public function render()
    {
        return view('livewire.client.lost-sms');
    }
}
