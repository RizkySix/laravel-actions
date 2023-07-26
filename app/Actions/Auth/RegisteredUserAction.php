<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Validation\Rules;

class RegisteredUserAction {
    use AsAction;


    public function handle(object $user) : void
    {

        $user = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => Hash::make($user->password),
        ]);

        event(new Registered($user));

        Auth::login($user);
       
    }

    public function rules() : array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }


    public function asController(ActionRequest $request) : RedirectResponse
    {
       $validated = $request->validated();
        $arr = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        $this->handle((object)$arr);
        return redirect(RouteServiceProvider::HOME);
    }

}