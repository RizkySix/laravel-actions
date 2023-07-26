<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class EmailVerificationNotificationAction {
    use AsAction;

    public function handle(User $user) : void
    {
        $user->sendEmailVerificationNotification();
    }

    public function asController(ActionRequest $request) : RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $this->handle($request->user());
        return back()->with('status', 'verification-link-sent');
    }
}