<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{

    public function getUser(Request $request)
    {
        UserResource::withoutWrapping();
        return new UserResource($request->user());
    }
}
