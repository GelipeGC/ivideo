<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Support\ResponseActionsTrait;

class RegisterRepository
{
    use ResponseActionsTrait;

    protected $model;

    public function __construct(User $user)
    {
        return $this->model = $user;
    }

    public function create(array $data)
    {
        try {

            $user = new $this->model;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);

            if ($user->save()) {
                return $this->sendSuccessfullyResponse('created', trans('user.create'), 201, $user);
            }
            return $this->sendFailedResponse('created', trans('user.failed'), 500);
        } catch (\Throwable $th) {
            return $this->sendFailedResponse('created', $th->getMessage(), 500);
        }
    }
}
