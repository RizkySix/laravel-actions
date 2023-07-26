<?php

use App\Actions\Auth\AuthenticatedSessionDestroyAction;
use App\Actions\Auth\AuthenticatedSessionStoreAction;
use App\Actions\Auth\ConfirmablePasswordAction;
use App\Actions\Auth\CreateLoginView;
use App\Actions\Auth\CreateNewPasswordView;
use App\Actions\Auth\CreatePasswordResetLinkView;
use App\Actions\Auth\CreateUserRegisteredView;
use App\Actions\Auth\EmailVerificationNotificationAction;
use App\Actions\Auth\EmailVerificationPromptAction;
use App\Actions\Auth\NewPasswordAction;
use App\Actions\Auth\PasswordAction;
use App\Actions\Auth\PasswordResetLinkAction;
use App\Actions\Auth\RegisteredUserAction;
use App\Actions\Auth\ShowConfirmablePassword;
use App\Actions\Auth\VerifyEmailAction;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', CreateUserRegisteredView::class)
                ->name('register');

    Route::post('register', RegisteredUserAction::class);

    Route::get('login', CreateLoginView::class)
                ->name('login');

    Route::post('login', AuthenticatedSessionStoreAction::class);

    Route::get('forgot-password', CreatePasswordResetLinkView::class)
                ->name('password.request');

    Route::post('forgot-password', PasswordResetLinkAction::class)
                ->name('password.email');

    Route::get('reset-password/{token}', CreateNewPasswordView::class)
                ->name('password.reset');

    Route::post('reset-password', NewPasswordAction::class)
                ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptAction::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailAction::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', EmailVerificationNotificationAction::class)
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', ShowConfirmablePassword::class)
                ->name('password.confirm');

    Route::post('confirm-password', ConfirmablePasswordAction::class);

    Route::put('password', PasswordAction::class)->name('password.update');

    Route::post('logout', AuthenticatedSessionDestroyAction::class)
                ->name('logout');
});
