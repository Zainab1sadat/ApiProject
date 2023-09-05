<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function SendVerificationEmail(Request $request){
        if ($request->user()->hasVerifiedEmail()) {
            return [
                'message'=>'Already Verified'
            ];
        }
        $request->user()->sendEmailVerificationNotification();
        return ['status'=>'Verification-link-sent'];
    }



    public function verify(Request $request)
    {
        auth()->loginUsingId($request->route('id'));


        if($request->route('id') != $request->user()->getKey()){
            throw new AuthorizationException();
        }


        if($request->user()->hasVerifiedEmail()){
            return response(['message'=>'Already verified']);
        }

        if($request->user()->markEmailAsVerified()){
            event(new Verified($request->user()));
        }

        return response(['message'=>'Successfuly verified']);
        
    }
}
