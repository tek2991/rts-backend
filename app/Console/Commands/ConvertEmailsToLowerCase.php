<?php

namespace App\Console\Commands;


use App\Models\User;
use Illuminate\Console\Command;

class ConvertEmailsToLowerCase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:lowercase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert all email addresses in the database to lowercase.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all records from the 'users' table (replace 'users' with your table name).
        $users = User::all();

        foreach ($users as $user) {
            $user->email = strtolower($user->email);
            $user->save();
        }

        $this->info('All email addresses in the database have been converted to lowercase.');
    }
}
