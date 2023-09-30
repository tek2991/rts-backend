<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ApkDownloadModal extends Component
{
    public $dontShow = false;

    public function mount()
    {
        $this->dontShow = !auth()->user()->pop_up;
    }

    public function updatedDontShow()
    {
        $this->validate([
            'dontShow' => 'boolean',
        ]);

        auth()->user()->update([
            'pop_up' => !$this->dontShow
        ]);
    }

    public function render()
    {
        return view('livewire.apk-download-modal');
    }
}
