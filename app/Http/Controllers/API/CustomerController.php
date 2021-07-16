<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{

    public function getAllData(Request $request)
    {

        $totalData = Customer::all();

        $data = Customer::paginate(10);

        $result = [];
        if (count($data) > 0) {
            foreach ($data as $d) {
                $result[] = [
                    'id'                => $d->id,
                    'name'              => $d->name,
                    'address'           => $d->address,
                    'contact'           => $d->contact,
                    'created_at'        => date('Y-m-d H:i:s', strtotime($d->created_at)),
                    'updated_at'        => date('Y-m-d H:i:s', strtotime($d->updated_at)),
                ];
            }
            $response = [
                'total' => $totalData->count(),
                'filtered_data' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'data'     => $result
            ];
        } else {
            $response = [
                'status'     => 200,
                'data'       => $result
            ];
        }

        return response()->json($response);
    }

    public function createCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
                'name'                  => $request->name,
                'address'               => $request->address,
                'contact'               => $request->contact,
            ]);

            if ($query) {
                $response = [
                    'message' => 'Data successfully created.',
                    'data'  => $query
                ];

                return response()->json($response, 201);
            } else {
                $response = [
                    'status'  => 400,
                    'message' => 'Data gagal diproses!',
                    'data'  => $request->all()
                ];

                return response()->json($response, 400);
            }
        }
    }
}
