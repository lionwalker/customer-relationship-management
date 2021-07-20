<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => ['required', Rules\Password::defaults()],
        ]);

        // Check email
        $user = User::whereEmail($validated['email'])->first();

        // Check password
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Login unsuccessful.']);
        }

        $token = $user->createToken('forum-app')->plainTextToken;

        return response()->json(['message' => 'Successfully logged in.', 'token' => $token])->header('Content-Type', 'application/json');
    }
}
