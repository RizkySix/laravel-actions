<?php

namespace App\Actions\Auth;

use Illuminate\View\View;
use Lorisleiva\Actions\Concerns\AsAction;

class ShowConfirmablePassword {
    use AsAction;

    public function handle() : View
    {
        return view('auth.confirm-password');
    }
}