<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if admin user can be authenticated';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = 'admin@example.com';
        $password = 'password123';
        
        $user = \App\Models\User::where('email', $email)->first();
        
        if (!$user) {
            $this->error('Admin user not found in database');
            return;
        }
        
        $this->info('Admin user found in database');
        $this->info('User ID: ' . $user->id);
        $this->info('User Name: ' . $user->name);
        $this->info('User Email: ' . $user->email);
        $this->info('Is Admin: ' . ($user->is_admin ? 'Yes' : 'No'));
        
        // Check if password matches
        if (\Illuminate\Support\Facades\Hash::check($password, $user->password)) {
            $this->info('Password is correct');
        } else {
            $this->error('Password is incorrect');
        }
    }
}
