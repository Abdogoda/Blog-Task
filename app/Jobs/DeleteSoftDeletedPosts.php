<?php

namespace App\Jobs;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class DeleteSoftDeletedPosts{

    public function handle(): void{
        // Delete posts that were soft deleted more than 30 days ago
        Post::onlyTrashed()
            ->where('deleted_at', '<=', Carbon::now()->subDays(30))
            ->forceDelete();
        Log::info("Old Soft Deleted Posts have been forcely delete successfully");
    }
}