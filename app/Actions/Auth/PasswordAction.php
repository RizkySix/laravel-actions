<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Lorisleiva\Actions\Concerns\AsAction;

class PasswordAction {
    use AsAction;

   public function handle(string $password , User $user) : void
   {
        $user->update([
            'password' => Hash::make($password),
        ]);
   }


   public function asController(Request $request) : RedirectResponse
   {
        $validated = $request->validateWithBag('updatePassword' , [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $this->handle($validated['password'] , $request->user());
        return back()->with('status', 'password-updated');
   }
}