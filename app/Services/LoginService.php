<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class LoginService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $email,
        public string $password,
        public bool $remember = true,
    )
    {
        //
    }

    public function handle(){
        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];
        $isLogin = Auth::attempt($credentials , $this->remember);
        if(!$isLogin){
            throw new \Exception("Invalid Email or Password");
        }

        return redirect()->intended('/dashboard-admin');
    }
}
