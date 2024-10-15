<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerificationRequest;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;

class VerificationController extends Controller{
    use ApiResponseTrait;

    public function __invoke(VerificationRequest $request){
        //###### get the user by its phone number
        $user = User::where('phone', $request->phone)->first();

        //###### check if the user exists and the verification code is right
        if ($user && $user->verification_code === $request->verification_code) {
            // change the user to verified and delete the verification code
            $user->verified_at = Carbon::now();
            $user->verification_code = null;
            $user->save();

            //###### return the response message
            return $this->success([], 'Account verified successfully, you can login now');
        }

        //###### if the user not found or the verification code incorrect return error message
        return $this->error('Invalid verification code', 401);
    }
}