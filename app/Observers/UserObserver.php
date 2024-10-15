<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver{
    public function created(User $user){
        $this->updateCache();
    }

    public function updated(User $user){
        $this->updateCache();
    }

    public function deleted(User $user){
        $this->updateCache();
    }

    public function restore(User $user){
        $this->updateCache();
    }

    public function forceDeleted(User $user){
        $this->updateCache();
    }

    protected function updateCache(){
        Cache::forget('user_post_stats');
    }
}