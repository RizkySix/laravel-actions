<?php

namespace App\Actions\Auth;

use Illuminate\View\View;
use Lorisleiva\Actions\Concerns\AsAction;

class CreatePasswordResetLinkView {
    use AsAction;

    public function handle() : View
    {
        return view('auth.forgot-password');
    }
}