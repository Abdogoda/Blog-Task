<?php

use App\Jobs\DeleteSoftDeletedPosts;
use App\Jobs\GetRandomUser;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


// send http get request to get a random user from this api
Schedule::job(new GetRandomUser)->everySixHours();

// Delete posts that were soft deleted more than 30 days ago
Schedule::job(new DeleteSoftDeletedPosts)->daily();