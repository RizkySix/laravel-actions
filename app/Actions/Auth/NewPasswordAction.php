<?php

namespace App\Actions\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class NewPasswordAction {
    use AsAction;

   public function handle(array $newPassword) : string
   {
    $status = Password::reset(
      $newPassword,
        function ($user) use ($newPassword) {
            $user->forceFill([
                'password' => Hash::make($newPassword['password']),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        }
    );

    return $status;
   }


   public function rules() : array
   {
        return  [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
   }

   public function asController(ActionRequest $request) : RedirectResponse
   {
       $status = $this->handle($request->only('email', 'password', 'password_confirmation', 'token'));

       return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
   }
}