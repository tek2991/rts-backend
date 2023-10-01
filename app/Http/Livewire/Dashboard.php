<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Subscription;

class Dashboard extends Component
{
    public $stats = [
        'total_users' => [
            'stat' => 0,
            'label' => 'Total users',
            'link' => '#'
        ],
        'users_without_subscription' => [
            'stat' => 0,
            'label' => 'Users without subscription',
            'link' => '#'
        ],
        'users_with_subscription' => [
            'stat' => 0,
            'label' => 'Users with subscription',
            'link' => '#'
        ],
        'users_with_active_subscription' => [
            'stat' => 0,
            'label' => 'Users with active subscription',
            'link' => '#'
        ],
        'total_amount_of_subscriptions' => [
            'stat' => 0,
            'label' => 'Total amount of subscriptions',
            'link' => '#'
        ],
    ];

    public $selected = 'total_users';
    
    public function mount()
    {
        // Count the number of users
        $total_users = User::role('client')->count();

        // Count the number of users who dont have have subscription
        $users_without_subscription = User::role('client')->whereDoesntHave('subscriptions')->count();

        // Count the number of users who have subscription
        $users_with_subscription = User::role('client')->whereHas('subscriptions')->count();

        // Count the number of users who have subscription and have active subscription
        $users_with_active_subscription = Subscription::where('started_at', '<', now())->where('expires_at', '>', now())->where('status', 'paid')->pluck('user_id')->unique()->count();

        // Total amount of subscriptions
        $total_amount_of_subscriptions = Subscription::where('status', 'paid')->sum('net_amount');
        $formatted_total_amount_of_subscriptions = number_format($total_amount_of_subscriptions, 2);

        $this->stats = [
            'total_users' => [
                'stat' => $total_users,
                'label' => 'Total users',
                'link' => route('user.index')
            ],
            'users_without_subscription' => [
                'stat' => $users_without_subscription,
                'label' => 'Users without subscription',
                'link' => '#'
            ],
            'users_with_subscription' => [
                'stat' => $users_with_subscription,
                'label' => 'Users with subscription',
                'link' => '#'
            ],
            'users_with_active_subscription' => [
                'stat' => $users_with_active_subscription,
                'label' => 'Users with active subscription',
                'link' => '#'
            ],
            'total_amount_of_subscriptions' => [
                'stat' => '₹ ' . $formatted_total_amount_of_subscriptions . ' /-',
                'label' => 'Total subscriptions',
                'link' => '#'
            ],
        ];
    }

    public function select($stat)
    {
        $this->selected = $stat;
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
