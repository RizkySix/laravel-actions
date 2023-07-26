<?php

namespace App\Actions\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class PasswordResetLinkAction {
    use AsAction;

    public function handle(array $email) : string
    {
        $status = Password::sendResetLink(
            $email
        );

        return $status ;
    
    }

    public function rules() : array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function asController(ActionRequest $request) : RedirectResponse
    {
      
       $status = $this->handle($request->only('email'));

       return $status == Password::RESET_LINK_SENT
       ? back()->with('status', __($status))
       : back()->withInput($request->only('email'))
               ->withErrors(['email' => __($status)]);
    }
}