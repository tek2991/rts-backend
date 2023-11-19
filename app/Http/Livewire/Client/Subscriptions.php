<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;
use App\Models\Subscription;
use Livewire\WithPagination;

class Subscriptions extends Component
{
    use WithPagination;

    public function mount()
    {
    }

    public function render()
    {
        $subscriptions = Subscription::where('user_id', auth()->id())
            ->with('package')
            ->with('coupon')
            ->with('activationCode')
            ->orderBy('id', 'desc')
            ->paginate();
            
        return view('livewire.client.subscriptions', compact('subscriptions'));
    }
}
