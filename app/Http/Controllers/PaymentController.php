<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Order;

class PaymentController extends Controller
{
    public function verify(Request $request)
    {
        try {

            // ✅ Razorpay init
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            // ✅ Fetch payment
            $payment = $api->payment->fetch($request->payment_id);

            if ($payment->status === 'captured') {

                // ✅ FIND EXISTING ORDER (VERY IMPORTANT)
                $order = Order::find($request->order_id);

                if($order){
                    $order->payment_id = $request->payment_id;
                    $order->payment_status = 'paid';
                    $order->status = 'processing';
                    $order->save();
                }

                return response()->json([
                    'success' => true,
                    'order_id' => $order->id
                ]);
            }

            return response()->json(['success' => false]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}