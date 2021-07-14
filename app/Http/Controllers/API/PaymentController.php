<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id'          => 'required',
            'reapair_fee'       => 'required',
            'dp'                => 'nullable',
            'type'              => 'nullable',
        ]);

        if ($validator->fails()) {
            $response = [
                'status'  => 400,
                'result'  => $validator->errors()
            ];

            return response()->json($response, 400);
        } else {
            $query = Payment::create([
                'order_id'              => $request->order_id,
                'reapair_fee'           => $request->reapair_fee,
                'dp'                    => $request->dp,
                'type'                  => $request->type,
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
