<?php
namespace App\Repositories;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new User());
    }
    function authenticate($credentials){
        try {
            config()->set('jwt.ttl', 60*60*365);
            if (! $token = JWTAuth::attempt($credentials)) {
                return [[
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 'code' => 400];
            }
        } catch (JWTException $e) {
            return [[
                    'success' => false,
                    'message' => 'Could not create token.',
                ], 'code' => 500];
        }
        return [[
            'token' => $token,
            'success' => true,
            'message' => 'created token successfully.',
            'userAuth' => auth()->user(),
        ], 'code' => 200];
    }

    function getToken($credentials){
        try {
            config()->set('jwt.ttl', 60*60*365);
            if (! $token = JWTAuth::attempt($credentials)) {
                return [[
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 'code' => 400];
            }
        } catch (JWTException $e) {
            return [[
                    'success' => false,
                    'message' => 'Could not create token.',
                ], 'code' => 500];
        }
        return [[
            'token' => $token,
            'success' => true,
            'message' => 'Could not create token.',
            'userAuth' => auth()->user(),
        ], 'code' => 200];
    }
}