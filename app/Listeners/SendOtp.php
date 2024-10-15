<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendOtp{

    public function handle(object $event): void{
        Log::info("OTP sent to {$event->phone} is: {$event->otp}");
    }
}