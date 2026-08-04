<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Reset UPI Daily Collections every midnight at 12:00 AM (00:00)
Schedule::command('upi:reset-daily-collection')->dailyAt('00:00');
