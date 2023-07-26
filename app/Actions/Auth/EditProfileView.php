<?php

namespace App\Actions\Auth;


use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\View\View;
use Lorisleiva\Actions\ActionRequest;

class EditProfileView {
    use AsAction;

    public function handle(ActionRequest $request) : View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }
}