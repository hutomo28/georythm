<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;

Schedule::command('orders:cancel-unpaid')->everyMinute();
// ->hourly(); // Depending on need, let's just make it run hourly or everyMinute. 
// I'll set it to hourly() which is standard, but the user didn't specify frequency. I'll stick to hourly() so it sweeps continuously.
