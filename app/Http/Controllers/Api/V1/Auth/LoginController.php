<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Events\OtpSent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller{
    use ApiResponseTrait;

    public function __invoke(LoginRequest $request){
        //###### get the user by its phone number
        $user = User::where('phone', $request->phone)->first();

        //###### check if the user not exists or the password is incorrect
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error("Invalid credentials!", 401);
        }

        //###### check if the account is not verified
        if (!$user->verified_at) {
            //###### send a verification to the user by firing the OtpSent event
            event(new OtpSent($user->phone, $user->verification_code));
            return $this->error('Account not verified, we send you a new OTP to verify your account!', 401);
        }

        //###### return the user and the token
        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->success(['user' => new UserResource($user), 'token' => $token], 'Logged In Successfully');
    }
}