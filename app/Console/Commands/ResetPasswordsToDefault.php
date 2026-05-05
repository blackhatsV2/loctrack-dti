<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetPasswordsToDefault extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-passwords-to-default';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all non-admin user passwords to Lastname@dti06';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('is_admin', false)->get();
        $count = 0;

        foreach ($users as $user) {
            $name = trim($user->name);
            
            if (str_contains($name, ',')) {
                $parts = explode(',', $name);
                $lastName = trim($parts[0]);
                $firstName = trim($parts[1] ?? '');
            } else {
                $parts = explode(' ', $name);
                $lastName = trim(array_pop($parts));
                $firstName = trim(implode('', $parts));
            }

            $password = strtolower(str_replace(' ', '', $lastName . $firstName)) . '06';
            $user->password = Hash::make($password);
            $user->save();
            $count++;
        }

        $this->info("Successfully reset {$count} passwords.");
    }
}
