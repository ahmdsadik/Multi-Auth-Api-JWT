<?php

namespace App\Http\Controllers\API\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('Api-Auth:user-api', ['except' => ['login', 'register']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required|string',
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'phone_number' => 'nullable|unique:users,phone_number',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors());
        }

        $user = User::create($validator->validate());

        $token = auth('user-api')->login($user);

        return $this->successResponse($this->respondWithToken($token));

    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'credit' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors());
        }

        $credentials = $request->only(['password']);

        if (filter_var($request->input('credit'), FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $request->input('credit');
        } elseif (intval($request->input('credit'))) {
            $credentials['phone_number'] = $request->input('credit');
        } else {
            $credentials['username'] = $request->input('credit');
        }

        if (!$token = auth('user-api')->attempt($credentials)) {
            return $this->errorResponse('Wrong credentials', 401);
        }

        return $this->successResponse($this->respondWithToken($token));
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        return $this->successResponse(auth('user-api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        auth('user-api')->logout();

        return $this->successResponse(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        return $this->successResponse($this->respondWithToken(auth('user-api')->refresh()));
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken(string $token): array
    {
        return [
            'user' => auth('user-api')->user(),
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('user-api')->factory()->getTTL() * 60
        ];
    }
}
