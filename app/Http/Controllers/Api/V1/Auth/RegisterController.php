<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Events\OtpSent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller{
    use ApiResponseTrait;

    public function __invoke(RegisterRequest $request){
        //###### create a new user account
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'verification_code' => random_int(100000, 999999),
        ]);

        //###### send a verification otp to the user by firing the OtpSent event
        event(new OtpSent($user->phone, $user->verification_code));

        //###### return the user
        $message = 'You have created your account successfully, and we send you a verification code so you can activate your account before login to the system.';
        return $this->success(['user' => new UserResource($user)], $message);
    }
}