<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;

class AuthController extends Controller
{
    
    public function unnauthorized()
    {
        return response()->json(['success' => false, 'message' => 'nao autorizado'], 401);
    }

    public function register(Request $request)
    {
        $data = $request->only([
            'name',
            'email',
            'password',
            'state_id'
        ]);

        $validator = Validator::make($data, [
            'state_id' => 'required|integer',
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $data['password'] = Hash::make($data['password']);

        $data['email_verified_at'] = now();
        $data['remember_token'] = Str::random(10);

        $newUser = User::create($data);
        
        $creds = $request->only('email', 'password');
        Auth::attempt($creds);

        $user = User::where('email', $creds['email'])->first();
        $item = time().rand(0, 9999);
        $token = $user->createToken($item)->plainTextToken;
        return response()->json(['success' => true, 'message' => 'usuario cadastrado e logado com sucesso', 'user' => $newUser, 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        $creds = $request->only('email', 'password');

        $validator = Validator::make($creds, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {

            return response()->json(['success' => false, $validator->messages()], 450);
        }

        if (!Auth::attempt($creds)) {

            return response()->json(['success' => false, 'email e/ou senha invalidos'], 400);
        }

        $user = User::where('email', $creds['email'])->first();

        $item = time() . rand(0, 9999);
        $token = $user->createToken($item)->plainTextToken;

        return response()->json(['success' => true, 'message' => 'usuario logado com sucesso', 'token' => $token], 200);
    }

    public function logout(Request $request)
    {

        $user = $request->user();

        $user->tokens()->delete();
        return response()->json(['success' => true, 'deslogado com suceso!'], 200);
    }
}
