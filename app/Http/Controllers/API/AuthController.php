<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
            'password' => Hash::make($request->password)
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
            return response()->json(['status' => '401', 'message' => 'Unauthorized'], 401);
        }
        $token = $user->createToken('mytoken')->plainTextToken;

        $response = [
            'status'  => 200,
            'result'  => $user,
            'token'   => $token
        ];

        return response()->json($response);
    }
    public function getDetail(Request $request)
    {

        $user = $request->user();

        $response = [
            'status'  => 200,
            'data'  => $user
        ];

        return response()->json($response);
    }
    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        $response = [
            'status'  => 200,
            'result'  => 'token deleted',
        ];

        return response()->json($response);
    }

    public function getAllData(Request $request)
    {

        if ($request->input('username')) {
            $data = User::where('username', 'LIKE', '%' . $request->username . '%')->get();
        } else {
            $data = User::all();
        }

        $result = [];
        if ($data) {
            if ($data->count() > 0) {
                foreach ($data as $d) {
                    $result[] = [
                        'id'                => $d->id,
                        'username'          => $d->username,
                        'role'              => $d->role,
                        'name'              => $d->name,
                        'created_at'        => date('Y-m-d H:i:s', strtotime($d->created_at)),
                        'updated_at'        => date('Y-m-d H:i:s', strtotime($d->updated_at)),
                    ];
                }
                $response = [
                    'status'     => '200',
                    'total_data' => count($result),
                    'result'     => $result,
                ];
            } else {
                $response = [
                    'total_data' => count($result),
                    'result'     => $result
                ];
            }
        } else {
            $response = [
                'message' => 'Server error!'
            ];
        }

        return response()->json($response);
    }
}
