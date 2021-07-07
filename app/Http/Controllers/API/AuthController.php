<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'  => 'required|unique:users,username',
            'name'      => 'required',
            'password'  => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'status'  => 400,
                'result'  => $validator->errors()
            ];

            return response()->json($response, 400);
        }

        $query = User::create([
            'username' => $request->username,
            'name'     => $request->name,
            'password' => Hash::make('123456')
        ]);

        $response = [
            'status'  => 200,
            'result'  => $query,
        ];

        return response()->json($response);
    }

    public function login(Request $request)
    {

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['Unauthorized'], 402);
        }
        $token = $user->createToken('mytoken')->plainTextToken;

        $response = [
            'status'  => 200,
            'result'  => $user,
            'token'   => $token
        ];

        return response()->json($response);
    }
}
