<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetRandomUser{
    
    public function handle(): void{
        // send http get request to get a random user from this api
        $response = Http::get('https://randomuser.me/api/');

        if ($response->successful()) {
            Log::info('Random User Data:', $response->json('results'));
        } else {
            Log::error('Failed to fetch random user data.');
        }
    }
}