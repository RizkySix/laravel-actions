<?php

use App\Actions\Auth\EditProfileView;
use App\Actions\Profile\ProfileDestroyAction;
use App\Actions\Profile\ProfileUpdateAction;
use App\Actions\UpdatePasswordAction;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', EditProfileView::class)->name('profile.edit');
    Route::patch('/profile', ProfileUpdateAction::class)->name('profile.update');
    Route::delete('/profile', ProfileDestroyAction::class)->name('profile.destroy');
});

require __DIR__.'/auth.php';
