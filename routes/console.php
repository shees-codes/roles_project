<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule database backup (daily at midnight)
Schedule::command('backup:database')->dailyAt('00:00');

// Schedule cache clearing (every hour)
Schedule::command('cache:clear')->hourly();

// Schedule session cleanup (every day at 3am)
Schedule::command('session:cleanup')->dailyAt('03:00');

// Schedule to clean old logs (weekly on Sundays at 2am)
Schedule::command('model:prune', ['--model' => 'App\\Models\\User'])->weeklyOn(0, '02:00');
