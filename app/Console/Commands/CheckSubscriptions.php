<?php

namespace App\Console\Commands;


use App\Models\User;
use Illuminate\Console\Command;

class CheckSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check user subscriptions.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all records from the 'users' table
        $users = User::all();

        foreach ($users as $user) {
            $subscriptions = $user->subscriptions;

            $last_date = null;

            foreach ($subscriptions as $subscription) {
                if ($subscription->status == 'paid') {
                    if ($last_date === null) {
                        $last_date = $subscription->expires_at;
                    } else {
                        $no_of_days = $subscription->duration_in_days;

                        $started_at = $last_date->addSecond();
                        $expires_at = clone $started_at;
                        $expires_at->addDays($no_of_days);

                        $subscription->update([
                            'started_at' => $started_at,
                            'expires_at' => $expires_at
                        ]);
                    }
                }
            }
        }

        $this->info('Subscriptions checked');
    }
}
