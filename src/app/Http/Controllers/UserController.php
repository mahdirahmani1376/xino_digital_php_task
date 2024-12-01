<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required'],
            'name' => ['required', 'string'],
        ]);

        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'name' => $data['name'],
        ]);

        return ['token' => $this->createTokenForUser($user)];

    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $attempt = Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        if (! $attempt) {
            throw new AuthenticationException;
        }

        $user = $request->user();

        return ['token' => $this->createTokenForUser($user)];

    }

    public function show()
    {
        return UserResource::make(
            request()->user()
        );
    }

    private function createTokenForUser(User $user)
    {
        return $user->createToken('access')->plainTextToken;
    }
}
