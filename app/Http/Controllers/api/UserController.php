<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserNamesResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function names()
    {
        $user = User::query()->find(1);
        return UserNamesResource::collection($user->my_agents);
        // return UserNamesResource::collection(Auth::user()->my_agents);
    }
}
