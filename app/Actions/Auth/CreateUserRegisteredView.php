<?php

namespace App\Actions\Auth;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\View\View;

class CreateUserRegisteredView {
    use AsAction;

    public function handle() : View
    {
        return view('auth.register');
    }
}