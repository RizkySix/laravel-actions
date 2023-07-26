<?php

namespace App\Actions\Auth;

use Illuminate\View\View;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNewPasswordView {
    use AsAction;

    public function handle(ActionRequest $request) : View
    {
        return view('auth.reset-password', ['request' => $request]);
    }
}