<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(UserLoginRequest $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
    public function logout(){
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    public function show(User $user){

      $user=User::findOrFail($user);
      return response()->json(['user' => $user]);
    }

    public function update(UserUpdateRequest $request, User $user){

        $user=User::findOrFail($user);
        $user->update($request->all());
        return response()->json(['message'=>'User Updated','user' => $user]);

    }
}
