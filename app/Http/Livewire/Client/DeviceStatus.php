<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class DeviceStatus extends Component
{
    public $device_id;
    public $device_token;
    public $formatted_device_status;
    public $device_status_updated_at;

    public $page;

    public function mount($page)
    {
        $this->refresh();
        $this->page = $page;

        if(!$this->formatted_device_status) {
            $this->refreshDeviceStatus();
        }
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

    public function sendNotification($action_to)
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

        // Send notification to device
        try {
            $message = CloudMessage::withTarget('token', $data['device_token'])
                ->withNotification(Notification::create($data['title'], $data['body']))
                ->withData(['action_to' => $data['action_to']])
                ->withAndroidConfig([
                    'priority' => 'high',
                    'direct_boot_ok' => true,
                ]);

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

    public function render()
    {
        return view('livewire.client.device-status');
    }
}
