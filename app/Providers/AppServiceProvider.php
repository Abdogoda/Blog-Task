<?php

namespace App\Providers;

use App\Events\OtpSent;
use App\Listeners\SendOtp;
use App\Models\Post;
use App\Models\User;
use App\Observers\PostObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void{
        // bind the event and listener
        Event::listen(
            OtpSent::class,
            SendOtp::class,
        );

        // register the model observer
        User::observe(UserObserver::class);
        Post::observe(PostObserver::class);
    }
}