<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\Login;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Register;
use App\Repositories\AuthRepository;
use App\Http\Requests\Auth\UpdateProfile;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private $authRepo;
    public function __construct(AuthRepository $authRepo)
    {
        $this->authRepo = $authRepo;
    }
 
    //Login
    public function login(Login $request)
    {
        $credentials = $request->validated();
        $response = $this->authRepo->authenticate($credentials);
        return response()->json($response[0], $response['code']);
    }

    //Registeration
    public function register(Register $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $data['rule_id'] = 2;
        $this->authRepo->create($data);
        $response = $this->authRepo->authenticate([
            'email' => $data['email'],
            'password' => $request->password
        ]);
        return response()->json($response[0], $response['code']);
    }

    //Update Profile
    public function update(UpdateProfile $request)
    {
        $data = $request->validated();
        $user = auth()->user();
        if($request->has('password')){
            $data['password'] = bcrypt($request->password);
        }
        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('avatars');
        }
        $this->authRepo->update($user->id, $data);
        return response()->json([
            'success' => true,
            'message' => 'Profile created successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }
 
    //Logout
    public function logout()
    {
        auth()->logout();
        return response()->json([
            'message' => 'logout succssfully',
        ]);
    }
 
    //User auth information
    public function details()
    {
        return auth()->user()->load('rule');
    }
}