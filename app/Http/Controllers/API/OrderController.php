<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function getAllData(Request $request)
    {

        $totalData = Order::all();

        if ($request->filled('status') && !$request->filled('from_date') && !$request->filled('to_date')) {
            $data = Order::where('status', $request->status)->paginate(10);
        } elseif ($request->filled('status') && $request->filled('from_date') && $request->filled('to_date')) {
            $start_date = Carbon::parse($request->from_date);
            $end_date = Carbon::parse($request->to_date);

            $from = $start_date->startOfDay();
            $to = $end_date->endOfDay();
            $data = Order::where('status', $request->status)->whereBetween('created_at', [$from, $to])->paginate(10);
        } elseif (!$request->filled('status') && $request->filled('from_date') && $request->filled('to_date')) {
            $start_date = Carbon::parse($request->from_date);
            $end_date = Carbon::parse($request->to_date);

            $from = $start_date->startOfDay();
            $to = $end_date->endOfDay();
            $data = Order::whereBetween('created_at', [$from, $to])->paginate(10);
        } else {
            $data = Order::paginate(10);
        }

        $result = [];
        if (count($data) > 0) {
            foreach ($data as $d) {
                $result[] = [
                    'id'                => $d->id,
                    'customer'          => $d->customer,
                    'item'              => $d->item,
                    'status'            => $d->status,
                    'problem'           => $d->problem,
                    'order_items'       => $d->orders,
                    'payment'           => $d->payment,
                    'estimated_date'    => $d->estimated_date,
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
                'data'     => $result
            ];
        }

        return response()->json($response);
    }

    public function getDataById($id)
    {
        $data = Order::where('id', $id)->get();

        $result = [];
        if ($data) {
            if ($data->count() > 0) {
                foreach ($data as $d) {
                    $result[] = [
                        'id'                => $d->id,
                        'customer'          => $d->customer,
                        'item'              => $d->item,
                        'status'            => $d->status,
                        'problem'           => $d->problem,
                        'order_items'       => $d->orders,
                        'payment'           => $d->payment,
                        'estimated_date'    => $d->estimated_date,
                        'created_at'        => date('Y-m-d H:i:s', strtotime($d->created_at)),
                        'updated_at'        => date('Y-m-d H:i:s', strtotime($d->updated_at)),
                    ];
                }
                $response = [
                    'status'        => 200,
                    'data'          => $result,
                ];
            } else {
                $response = [
                    'total_data'    => count($result),
                    'status'        => 200,
                    'data'          => $result,
                ];
            }
        } else {
            $response = [
                'message' => 'Server error!'
            ];
        }

        return response()->json($response);
    }

    public function createOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status'            => 'required',
            'customer_id'       => 'required',
            'item'              => 'required',
            'problem'           => 'nullable',
            'estimated_date'    => 'nullable',
        ]);

        if ($validator->fails()) {
            $response = [
                'status'  => 400,
                'result'  => $validator->errors()
            ];

            return response()->json($response, 400);
        } else {
            $query = Order::create([
                'status'                => $request->status,
                'customer_id'           => $request->customer_id,
                'item'                  => $request->item,
                'problem'               => $request->problem,
                'estimated_date'        => $request->estimated_date,
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
                    'result'  => $request->all()
                ];

                return response()->json($response, 400);
            }
        }
    }
    public function updateOrder(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status'            => 'required',
            'problem'           => 'nullable',
            'estimated_date'    => 'nullable',
        ]);

        if ($validator->fails()) {
            $response = [
                'status'  => 400,
                'result'  => $validator->errors()
            ];

            return response()->json($response, 400);
        } else {
            $query = Order::where('id', $id)->update([
                'status'                => $request->status,
                'problem'               => $request->problem,
                'estimated_date'        => $request->estimated_date,
            ]);

            if ($query) {
                $response = [
                    'message'       => 'Data successfully updated.',
                    'status'        => 200,
                    'data'          => $query,
                ];

                return response()->json($response, 200);
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
