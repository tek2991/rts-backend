<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PublicDealer extends Component
{
    public $states = [];
    public $districts = [];
    public $dealers = null;

    public $state_id;
    public $district_id;

    public function mount()
    {
        $this->states = \App\Models\StateModel::all();
    }

    public function updatedStateId($value)
    {
        $this->districts = \App\Models\District::where('state_id', $value)->get();
    }

    public function search()
    {
        $this->dealers = \App\Models\Dealer::where('district_id', $this->district_id)
            ->with('district', 'district.state')
            ->get();
    }

    public function render()
    {
        return view('livewire.public-dealer');
    }
}
