<?php

namespace App\Actions\Profile;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Lorisleiva\Actions\Concerns\AsAction;

class ProfileDestroyAction {
    use AsAction;

    public function handle(User $user) : void
    {
        Auth::logout();

        $user->delete();

    }

    public function asController(Request $request) : RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

       $this->handle($request->user());
     
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}