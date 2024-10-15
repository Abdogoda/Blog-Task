<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver{

    public function created(Post $post){
        $this->updateCache();
    }

    public function updated(Post $post){
        $this->updateCache();
    }

    public function deleted(Post $post){
        $this->updateCache();
    }

    public function restore(Post $post){
        $this->updateCache();
    }

    public function forceDeleted(Post $post){
        $this->updateCache();
    }

    protected function updateCache(){
        Cache::forget('user_post_stats');
    }
}