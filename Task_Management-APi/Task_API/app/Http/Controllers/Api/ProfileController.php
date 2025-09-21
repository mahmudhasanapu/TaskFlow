<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\Base\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends BaseApiController
{
    //update 
    public function update(UpdateProfileRequest $request){
        $user = Auth::user();
        $data = $request->validated();
        if (isset($data['password'])){
            $data['password'] = bcrypt($data['password']);
        }
        $user->update($data);
        //update cache
        $cacheKey = "user_profile_{$user->id}";
        Cache::put($cacheKey, new UserResource($user), now()->addHours(1));
        return $this->success(new UserResource($user), 'profile updated successfully');
    }
}
