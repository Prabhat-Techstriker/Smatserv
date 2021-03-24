<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(Request $request)
    {
        /* Function for login/signup */
        $validator = \Validator::make($request->all(), [
            'phone_number' => 'required',
            /* 'name' => 'required|string',
            'email' => 'required|string|email|unique:users',             
            'role' => 'required|integer',
            'password' => 'required|between:8,15|string|confirmed' */
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors(), 'message' => 'Validation failed.'], 422);
        }

        if (User::where('phone_number', $request->phone_number)->exists()) {
            $user = User::where('phone_number', $request->phone_number)->first();
        }else{
            $user = User::create($request->all());
        }

        //$user = $request->user();
        $user->device_token = $request->device_token;
        $user->save();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'success' => true,
            'user' => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ],201);
    }
}
