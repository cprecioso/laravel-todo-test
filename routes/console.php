<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('make-invite', function () {
    $project = App\Models\Project::find(3);
    $email = 'my@test.invalid';

    $controller = app()->make(App\Http\Controllers\ProjectInviteController::class);

    $this->comment($controller->createInviteURL($project, $email));
});
