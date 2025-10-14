<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use function Laravel\Prompts\form;

class EditAdminAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:edit-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'edit admin account';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::first();
        if(!$user){
            $this->info('belum ada akun admin !');
            $this->info('buat akun baru');
            $this->call('app:create-admin');
            return;
        }
        $responses = form()
        ->text('New Full Name', required: true, name: 'name' , default: $user->name)
        ->text('New Email', required: true, validate: ['email', 'unique:users,email,'.$user->id], name: 'email' , default: $user->email)
        ->text('New Password', required: true, validate: ['password' => 'min:8'], name: 'password')
        ->submit();

        $user->fill($responses);
        if ($user->save()) {
            $this->info("Update Admin Account Success");
            return;
        } else {
            $this->error("Update Admin Account Failed");
            return;
        }
    }
}
