<?php

namespace App\Actions\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class ConfirmablePasswordAction {
    use AsAction;

    public function handle(string $email , string $password) : void
    {
        if (! Auth::guard('web')->validate([
            'email' => $email,
            'password' => $password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

    }

    public function asController(ActionRequest $request) : RedirectResponse
    {
        $this->handle($request->user()->email , $request->password);
        return redirect()->intended(RouteServiceProvider::HOME);
    }
}