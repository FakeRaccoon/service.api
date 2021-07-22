<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartController extends Controller
{
    public function getAllData(Request $request)
    {

        $totalData = Part::all();

        $data = Part::where('name', 'LIKE', '%' . $request->name . '%')->paginate(10);

        $result = [];
        if (count($data) > 0) {
            foreach ($data as $d) {
                $result[] = [
                    'id'                => $d->id,
                    'name'              => $d->name,
                    'created_at'        => date('Y-m-d H:i:s', strtotime($d->created_at)),
                    'updated_at'        => date('Y-m-d H:i:s', strtotime($d->updated_at)),
                ];
            }
            $response = [
                'status'    => 200,
                'data'      => $result,
                'meta'     => [
                    'total' => $totalData->count(),
                    'filtered_data' => $data->count(),
                    'per_page' => $data->perPage(),
                    'current_page' => $data->currentPage(),
                ],
            ];
        } else {
            $response = [
                'status'     => 200,
                'data'       => $result
            ];
        }

        return response()->json($response);
    }

    public function createPart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'            => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'status'  => 400,
                'data'  => $validator->errors()
            ];

            return response()->json($response, 400);
        } else {
            $query = Part::create([
                'name'        => $request->name,
            ]);

            if ($query) {
                $response = [
                    'message'       => 'Data successfully created.',
                    'status'        => 201,
                    'data'          => $query,
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
