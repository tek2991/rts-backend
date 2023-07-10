<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Gst extends Component
{
    public $cgst;
    public $sgst;

    public function mount()
    {
        $this->cgst = \App\Models\Gst::where('name', 'CGST')->first();
        $this->sgst = \App\Models\Gst::where('name', 'SGST')->first();
    }

    public function render()
    {
        return view('livewire.gst');
    }
}
