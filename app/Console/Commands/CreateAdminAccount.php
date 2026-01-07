<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use function Laravel\Prompts\form;
class CreateAdminAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create admin account';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $responses = form()
            ->text('Full Name', required: true, name: 'name')
            ->text('Email', required: true, validate: ['email', 'unique:users,email'], name: 'email')
            ->text('Password', required: true, validate: ['password' => 'min:8'], name: 'password')
            ->submit();
        $user = new User($responses);
        if ($user->save()) {
            $this->info("Create Admin Account Success");
            return;
        } else {
            $this->error("Create Admin Account Failed");
            return;
        }
    }
}
