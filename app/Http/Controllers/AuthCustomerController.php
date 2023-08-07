<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use JWTAuth;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        try {
        $def_pass = Str::random(8);
        $validator = Validator::make($request->all(), [
            'nama_customer' =>  'required|string|between:2,100',
            'alamat' => 'required|string|between:2,100',
            'kota' => 'required|string|between:2,100',
            'no_telepon' => 'required|string|between:2,50',
            'level' => 'required',
            'no_identitas' => 'required|string|between:2,50',
            'email' => 'required|string|email|max:100|unique:users',
            'file_identitas' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'file_lokasi' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create([
            'name' => $request->get('nama_customer'),
            'email' => $request->get('email'),
            'password' => Hash::make($def_pass),
            'isUser' => 1, //Customer
        ]);

        $nmFileId = $request->file_identitas->store('customer');
        $nmFileLokasi = $request->file_lokasi->store('customer');

        $customer = CustomerModel::create([
            'kode' => $this->create_no_customer(),
            'nama_customer' => $request->get('nama_customer'),
            'alamat' => $request->get('alamat'),
            'kota' => $request->get('kota'),
            'no_telepon' => $request->get('no_telepon'),
            'level' => $request->get('level'),
            'no_identitas' => $request->get('no_identitas'),
            'lat' => $request->get('lat'),
            'lng' => $request->get('lng'),
            'file_identitas' => $nmFileId,
            'file_lokasi' => $nmFileLokasi,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Customer successfully registered',
            'user' => $user,
            'customer' => $customer,
            'pass' => $def_pass,
        ], 200);
        } catch(\Exception $e){
            return response()->json([
                'message' => 'Customer failed registered',
                'error' => $e->getMessage(),
            ], 500);
            throw new HttpException(500, $e->getMessage());
        }
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

    public function create_no_customer()
    {
        $no_urut = 1;
        $kd="UTB-";

        $result = CustomerModel::withTrashed()->orderby('id', 'desc')->first();
        if(empty($result->kode)) {
            $no_baru = $kd.sprintf('%04s', $no_urut);
        } else {
            $no_trans_baru = (int)substr($result->kode, 4, 4) + 1;
            $no_baru = $kd.sprintf('%04s', $no_trans_baru);
        }
        return $no_baru;
    }
}
