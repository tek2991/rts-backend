<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class TextToSpeech extends Component
{
    public $device_id;
    public $device_token;
    public $formatted_device_status;
    public $device_status_updated_at;

    public $user;

    public $max_chars = 160;
    public $message = '';
    public $message_length = 0;


    public $languages = [
        'bn' => 'Bengali',
        'en' => 'English',
        'hi' => 'Hindi',
    ];

    public $selected_language = 'en';
    
    public function mount()
    {
        $this->user = auth()->user();
        $this->refresh();
    }

    public function refresh()
    {
        $this->device_id = auth()->user()->device_id;
        $this->device_token = auth()->user()->device_token;
        $this->formatted_device_status = auth()->user()->formattedDeviceStatus();
        $this->device_status_updated_at = auth()->user()->device_status_updated_at;
    }

    public function contRefresh()
    {
        $this->formatted_device_status = auth()->user()->formattedDeviceStatus();
        $this->device_status_updated_at = auth()->user()->device_status_updated_at;
    }

    public function sendNotification($action_to, $language=null, $message=null)
    {
        // If device token is empty
        if (empty($this->device_token)) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'No Device token! Please register your device first',
            ]);
            return;
        }

        $data = [
            'device_token' => $this->device_token,
            'title' => null,
            'body' => null,
            'action_to' => $action_to,
        ];

        if($action_to == 'text_to_speech') {
            $data['message'] = $message;
            $data['language'] = $language;
        }

        // Send notification to device
        try {
            $message = CloudMessage::withTarget('token', $data['device_token'])
                ->withNotification(Notification::create($data['title'], $data['body']));
            
            if($action_to == 'text_to_speech') {
                $message->withData(['action_to' => $data['action_to'], 'message' => $data['message'], 'language' => $data['language']]);
            } else {
                $message->withData(['action_to' => $data['action_to']]);
            }

            $messaging = app('firebase.messaging');
            $messaging->send($message);

            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'success',
                'message' => 'Notification sent for: ' . $action_to . '!',
            ]);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'danger',
                'message' => 'Failed to send ' . $action_to . ' notification! - ' . $th->getMessage(),
            ]);
        }
    }

    public function refreshDeviceStatus()
    {
        $this->sendNotification('device_status');
    }

    public function updatedMessage()
    {
        $this->message_length = strlen($this->message);
    }

    public function sendTextToSpeech()
    {
        $this->sendNotification('text_to_speech', $this->selected_language, $this->message);

        $this->message = '';
        $this->message_length = 0;
    }

    public function render()
    {
        return view('livewire.client.text-to-speech');
    }
}
