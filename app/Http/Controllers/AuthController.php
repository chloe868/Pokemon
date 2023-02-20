<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // public function __construct() {
    //     $this->middleware('jwt.verify', ['except' => ['login', 'register']]);
    // }
    
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'username' => 'required|string|between:2,100',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'username' => 'required|string|between:2,100',
            'password' => 'required|string|confirmed|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
        $token = JWTAuth::fromUser($user);
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function logout() {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['token' => NULL]);
    }
    
    public function refresh() {
        $current_token = JWTAuth::getToken();
        $token = JWTAuth::refresh($current_token);
        return $this->createNewToken($token);
    }
    
    public function userProfile() {
        return response()->json(['test' => 'successs']);
        // return response()->json(auth()->user());
    }
    
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
