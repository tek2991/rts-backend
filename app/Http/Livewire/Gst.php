<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Gst extends Component
{
    public $cgst;
    public $sgst;

    public $cgst_rate;
    public $sgst_rate;

    public $success = false;

    public function mount()
    {
        $this->cgst = \App\Models\Gst::where('name', 'CGST')->first();
        $this->sgst = \App\Models\Gst::where('name', 'SGST')->first();

        $this->cgst_rate = $this->cgst->rate;
        $this->sgst_rate = $this->sgst->rate;
    }

    public function save()
    {
        $this->validate([
            'cgst_rate' => 'required|numeric|min:0',
            'sgst_rate' => 'required|numeric|min:0',
        ]);

        $this->cgst->update([
            'rate' => $this->cgst_rate,
        ]);

        $this->sgst->update([
            'rate' => $this->sgst_rate,
        ]);

        $this->success = 'GST rates updated successfully.';
    }

    public function render()
    {
        return view('livewire.gst');
    }
}
