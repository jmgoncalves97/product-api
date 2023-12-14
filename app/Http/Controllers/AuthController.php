<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('name', 'password'))) {
            return response()->json([
                'user' => auth()->user(),
                'token' => auth()->user()->createToken('API Token')->plainTextToken,
            ]);
        }

        throw ValidationException::withMessages([
            'name' => ['As credenciais estão incorretas.'],
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out feito com sucesso',
        ]);
    }
}
