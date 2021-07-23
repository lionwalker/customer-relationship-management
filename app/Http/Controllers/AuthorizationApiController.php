<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Symfony\Component\HttpFoundation\Response;

class AuthorizationApiController extends Controller
{
    /**
     * @OA\Post(
     *      path="/login",
     *      operationId="loginUser",
     *      tags={"Authentication"},
     *      summary="Login the user",
     *      description="Login the user",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/LoginResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
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
            return response(['message' => 'Login unsuccessful.'], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('forum-app')->plainTextToken;

        return response(['message' => 'Successfully logged in.', 'token' => $token], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/logout",
     *      operationId="logoutUser",
     *      tags={"Authentication"},
     *      summary="Logout the authenticated user",
     *      description="Logout the authenticated user",
     *      security={{"sanctum":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/LogoutResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response(['message' => 'Successfully logged out.'], Response::HTTP_OK);
    }
}
