<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Repositories\RegisterRepository;

class RegisterController extends Controller
{
    private $registerRepository;
    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct(RegisterRepository $register)
    {
        $this->registerRepository = $register;

        $this->middleware('guest');
    }
    public function register(RegisterRequest $request)
    {
        return $this->registerRepository->create($request->validated());
    }
}
