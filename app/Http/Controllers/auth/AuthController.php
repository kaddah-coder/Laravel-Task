<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Repository\Eloquent\UserRepository;
use App\Traits\ResponseTrait;

class AuthController extends Controller
{
    use ResponseTrait;

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);

        $this->userRepository = $userRepository;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {

            return $this->sendError('Unauthorized', 401);
        }

        $user = Auth::user();

        return $this->sendResponse('User Logged Successfully!', new UserResource($user),['token' => $token, 'type' => 'bearer',], 200);
    }

    public function register(RegisterRequest $request)
    {

        $user = $this->userRepository->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return $this->sendResponse('User Created Successfully!', new UserResource($user), null, 200);
    }

    public function logout()
    {
        Auth::logout();
        return $this->sendResponse('Successfully User logged out', null, null, 200);
    }

    public function refresh()
    {
        $tokenRef = Auth::refresh();
        return $this->sendResponse('Successfully User Token refreshed!', new UserResource(Auth::user()), ['token' => $tokenRef, 'type' => 'bearer',], 200);
    }
}
