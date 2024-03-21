<?php

namespace App\Http\Controllers;

use App\Filters\V1\UsersFilter;
use App\Http\Requests\LoginUserRequest;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \App\Http\Requests\StoreUserRequest;

class AuthController extends ResponseController
{
    //use HttpResponses;
    public function index(Request $request)
    {

        $filter = new UsersFilter();
        $users = User::where($filter->transform($request));

        return new UserCollection($users->paginate(5)->appends($request->query()));
    }

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Credentials do not match', 401);
        }
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('user token')->plainTextToken;

        $success = [
            'user' => $user,
            'token' => $token,
        ];

        return $this->sendResponse($success, 'Data successfully processed.');
    }

    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all());

        $user = User::create([
            //'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('user token')->plainTextToken;

        $success = [
            'user' => $user,
            'token' => $token,
        ];

        return $this->sendResponse($success, 'Data successfully processed.');
    }
    public function logout()
    {
        return response()->json('This is my logout method');
    }
}
