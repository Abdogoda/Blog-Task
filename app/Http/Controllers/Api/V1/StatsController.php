<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StatsController extends Controller{
    use ApiResponseTrait;

    public function __invoke(){
        $stats = Cache::remember('user_post_stats', 60, function () {
            $totalUsers = User::count();
            $totalPosts = Post::count();        
            $usersWithZeroPosts = User::leftJoin('posts', 'users.id', '=', 'posts.user_id')
            ->whereNull('posts.id')
            ->count('users.id');

            return [
                'total_users' => $totalUsers,
                'total_posts' => $totalPosts,
                'users_with_zero_posts' => $usersWithZeroPosts,
            ];
        });

        return $this->success(['stats' => $stats], 'Statistics retrieved successfully');
    }
}