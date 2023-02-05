<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\ProfileRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Repository\Eloquent\UserRepository;
use App\Traits\ResponseTrait;

class ProfileController extends Controller
{
    use ResponseTrait;

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth:api');
        $this->userRepository = $userRepository;
    }


    public function getDataProfile()
    {
        $user = Auth::user();
        return $this->sendResponse('User Profile Information!', new UserResource($user), null, 200);
    }

    public function updateProfile(ProfileRequest $request)
    {
        $user = $this->userRepository->update(Auth::id(), [
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return $this->sendResponse('User Profile Updated!', new UserResource($user), null, 200);
    }
}
