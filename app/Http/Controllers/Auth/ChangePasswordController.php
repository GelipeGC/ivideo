<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Support\ResponseActionsTrait;
use App\Http\Requests\Auth\ChangePasswordRequest;

class ChangePasswordController extends Controller
{
    use ResponseActionsTrait;

    public function changePassword(ChangePasswordRequest $request)
    {
        if (Hash::check($request->password, $request->user()->password)) {
            $user = User::find($request->user()->id);

            $user->password = Hash::make($request->new_password);
            $user->save();

            return $this->sendSuccessfullyResponse('success', 'Contraseña cambiada con éxito', 200, []);
        }

        return response(["errors" => ["password" => ["La contraseña actual es incorrecta."]]], 422);
    }
}
