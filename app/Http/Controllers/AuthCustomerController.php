<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use JWTAuth;

class AuthCustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = JWTAuth::fromUser(Auth::user());
        return $this->respondWithToken($token, $user);
    }

    public function register(Request $request)
    {
        $def_pass = Str::random(8);
        $validator = Validator::make($request->all(), [
            'nama_customer' =>  'required|string|between:2,100',
            'alamat' => 'required|string|between:2,100',
            'kota' => 'required|string|between:2,100',
            'no_telepon' => 'required|string|between:2,50',
            'level' => 'required',
            'no_identitas' => 'required|string|between:2,50',
            'email' => 'required|string|email|max:100|unique:users'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('nama_customer'),
            'email' => $request->get('email'),
            'password' => Hash::make($def_pass),
        ]);
        // $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            // 'token' => $token,
            'pass' => $def_pass
        ], 200);
    }

    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60, //mention the guard name inside the auth fn
            'token' => $user,
            'user' => Auth::user()
        ]);
    }

    public function guard()
    {
        return Auth::guard();
    }
}
