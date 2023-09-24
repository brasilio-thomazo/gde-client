<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function login(Request $request): Response
    {
        $this->validate($request, [
            'username' => 'required|string|exists:users,username',
            'password' => 'required|string',
            'guard'    => 'nullable|in:guard,web,system'
        ]);

        $guard = $request->get('guard', 'web');

        $credentials = $request->only(['username', 'password']);

        if (!auth($guard)->attempt($credentials)) {
            throw new AuthenticationException();
        }

        /**
         * @var User
         */
        $user = auth($guard)->user();
        $user->groups;
        $user->department;
        return response($user, 200);
    }

    public function me()
    {
        /**
         * @var User
         */
        $user = auth()->user();
        $user->groups;
        $user->department;
        // $user['authorities'] = auth()->payload()['authorities'];
        return response($user, 200);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return response([], 204);
    }

    public function apiLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string|exists:users,username',
            'password' => 'required|string'
        ]);

        $credentials = $request->only('username', 'password');
        if (!$jwt = auth('api')->attempt($credentials)) {
            throw ValidationException::withMessages(['password' => 'password not valid'], 401);
        }



        $token = [
            'data' => $jwt,
            'type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];

        $user = auth('api')->user();
        $user->groups;
        $user['token'] = $token;

        return response($user);
    }

    public function apiMe()
    {
    }
}
