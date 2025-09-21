<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Base\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseApiController
{
    //User Registration
    public function register(RegisterRequest $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return $this->success(new UserResource($user), message: 'User Register Successfully', code: 201);
    }
    
    //User Login
    public function login(LoginRequest $request){
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)) {
            return $this->error( 'Invalid Email or Password', code:401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->success([
            'user' => new UserResource($user),
            'token' => $token,
        ], 'Login Successful');
    }

    //Profile-me
    public function me(Request $request){
        $user = $request->user();
        $cacheKey = "user_profile_{$user->id}";
        // if (Cache::has($cacheKey)) {
        //     logger("profile Loaded from cache: {$cacheKey}");
        // }else{
        //     logger("profile not found in catch: {$cacheKey}");
        // }
        $cached = Cache::remember($cacheKey,now()->addHours(1),function()use($user){
            return new UserResource($user);
        });
        return $this->success($cached, 'User Profile Retrieved Successfully');
    }

    //Logout
    public function logout(Request $request){
        $user = $request->user();
        $cacheKey = "user_profile_{$user->id}";
        Cache::forget($cacheKey);
        $request->user()->currentAccessToken()->delete();
        return $this->success(null, 'Logout Successful');
    }
}
