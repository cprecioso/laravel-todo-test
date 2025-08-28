<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('projects/new', \App\Livewire\Projects\NewInput::class)
    ->middleware(['auth', 'verified'])
    ->name('projects.new');

Route::get('projects/{project}', \App\Livewire\Projects\Contents::class)
    ->middleware(['auth', 'verified'])
    ->name('project');

Route::get('accept-invite/{projectInvite}', [\App\Http\Controllers\ProjectInviteController::class, 'accept'])
    ->middleware(['auth', 'verified'])
    ->name('project-invite.accept');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';
