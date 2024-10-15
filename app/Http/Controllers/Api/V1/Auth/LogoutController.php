<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class LogoutController extends Controller{
    use ApiResponseTrait;

    public function __invoke(Request $request){
        $request->user()->currentAccessToken()->delete();

        return $this->success([], 'Logged out successfully');
    }
}