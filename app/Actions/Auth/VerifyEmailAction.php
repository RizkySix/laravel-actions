<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Lorisleiva\Actions\Concerns\AsAction;

class VerifyEmailAction {
    use AsAction;


    public function handle(User $user) : void
    {
    
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

       
    }

    public function asController(EmailVerificationRequest $request) : RedirectResponse
    {
        $this->handle($request->user());
        return $request->user()->hasVerifiedEmail() ? 
            redirect()->intended(RouteServiceProvider::HOME.'?verified=1') : 
            redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }

}