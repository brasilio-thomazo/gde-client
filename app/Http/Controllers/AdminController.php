<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AuthRequest;
use App\Models\Admin\User;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function index(): Response
    {
        $builder = User::with(['groups', 'groups.privilege']);
        return response($builder->get());
    }

    public function login(AuthRequest $request): Response
    {
        $credentials = $request->only('username', 'password');
        if (!$jwt = auth('system')->attempt($credentials)) {
            throw ValidationException::withMessages(['password' => 'password not valid'], 401);
        }

        $response = [
            'token' => $jwt,
            'type' => 'bearer',
            'expires_in' => auth('system')->factory()->getTTL() * 60
        ];

        return response($response);
    }
}
