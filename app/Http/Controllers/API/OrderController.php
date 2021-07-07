<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getAllData()
    {
        $data = Order::get();

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
                        'orders'            => $d->orders,
                        'payment'            => $d->payment,
                        'created_at'        => date('Y-m-d H:i:s', strtotime($d->created_at)),
                    ];
                }
                $response = [
                    'status'     => 200,
                    'total_data' => count($result),
                    'result'     => $result
                ];
            } else {
                $response = [
                    'status'     => 200,
                    'total_data' => count($result),
                    'result'     => $result
                ];
            }
        } else {
            $response = [
                'status'  => 500,
                'message' => 'Server error!'
            ];
        }

        return response()->json($response);
    }
}
