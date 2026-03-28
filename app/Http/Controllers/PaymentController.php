<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{
    public function verify(Request $request)
    {
        $paymentId = $request->payment_id;

        // Get latest order
        $order = Order::latest()->first();

        if($order){
            $order->payment_id = $paymentId;
            $order->payment_status = 'paid';
            $order->save();
        }

        return response()->json(['success' => true]);
    }
}