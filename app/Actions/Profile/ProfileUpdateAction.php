<?php

namespace App\Actions\Profile;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Lorisleiva\Actions\Concerns\AsAction;

class ProfileUpdateAction {
    use AsAction;

    public function handle(User $user , array $newData) : void
    {
        $user->fill($newData);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
    }

    public function asController(ProfileUpdateRequest $request) : RedirectResponse
    {
        $this->handle($request->user() , $request->validated());
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
}