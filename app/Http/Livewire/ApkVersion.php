<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ApkVersion extends Component
{
    public $apkVersionModel;

    public $apkVersion;

    public $success = false;

    public function mount()
    {
        $this->apkVersionModel = \App\Models\ApkVersion::first();
        $this->apkVersion = $this->apkVersionModel->version;
    }

    public function save()
    {
        $this->validate([
            'apkVersion' => 'required|numeric|min:0',
        ]);

        $this->apkVersionModel->update([
            'version' => $this->apkVersion,
        ]);

        $this->success = 'APK version updated successfully.';
    }

    public function render()
    {
        return view('livewire.apk-version');
    }
}
