<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
    public function show(){

      $user=User::findOrFail(auth()->id());
      return response()->json(['user' => $user]);
    }



    public function update(UserUpdateRequest $request): JsonResponse
    {
        $user = User::findOrFail(auth()->id());



        $updatedFields = 0;

        if ($request->has('name')) {

            $user->name = $request->input('name');

            $updatedFields++;
        } elseif ($request->has('email')) {
            $user->email = $request->input('email');
            $updatedFields++;
        }



        if ($updatedFields === 0) {
            return response()->json([
                'message' => 'No fields provided for update. Please provide at least one field (name, email, ) for update.',
            ], 400);
        }


        $user->save();

        return response()->json([
            'message' => 'User info updated successfully',
            'user' => $user
        ], 201);
    }


}
