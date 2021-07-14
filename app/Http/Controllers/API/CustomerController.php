<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function createCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id'          => 'required',
            'name'              => 'required',
            'address'           => 'nullable',
            'contact'           => 'nullable',
        ]);

        if ($validator->fails()) {
            $response = [
                'status'  => 400,
                'result'  => $validator->errors()
            ];

            return response()->json($response, 400);
        } else {
            $query = Customer::create([
                'order_id'              => $request->order_id,
                'name'                  => $request->name,
                'address'               => $request->address,
                'contact'               => $request->contact,
            ]);

            if ($query) {
                $response = [
                    'message' => 'Data successfully created.',
                    'result'  => $request->all()
                ];

                return response()->json($response, 201);
            } else {
                $response = [
                    'status'  => 400,
                    'message' => 'Data gagal diproses!',
                    'result'  => $request->all()
                ];

                return response()->json($response, 400);
            }
        }
    }
}
