<?php

namespace App\Http\Controllers;

use App\Enums\Course;
use App\Enums\Role;
use App\Enums\Type;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'signUp']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => __('auth.failed')], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Register the user.
     *
     */
    public function signUp(Request $request): JsonResponse
    {
        $courses = join( ',', Course::getValues());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'enrollment_number' => 'required|numeric',
            'course' => "required|in:{$courses}",
        ]);

        $user = User::create([
            ...$validated,
            'type' => Type::Student->value,
            'role' => Role::Requester->value,
        ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     */
    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     */
    public function logout(): Response
    {
        auth()->logout();

        return response()->noContent();
    }

    /**
     * Refresh a token.
     *
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
