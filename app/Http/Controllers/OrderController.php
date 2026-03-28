<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    // Checkout page
    public function checkout()
    {
        $cart = session('cart', []);

        if(empty($cart)){
            return redirect()->route('cart')->with('error','Cart is empty');
        }

        return view('checkout', compact('cart'));
    }

    // Place order
    public function placeOrder(Request $request)
    {
        $cart = session('cart', []);

        if(empty($cart)){
            return redirect()->route('cart')->with('error','Cart is empty');
        }

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        $total = 0;

        foreach($cart as $item){
            $total += $item['price'] * $item['quantity'];
        }

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'total' => $total,
        ]);

        // Save items
        foreach($cart as $id => $item){
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('home')->with('success','Order placed successfully!');
    }

    // ADMIN: View all orders
    public function adminOrders()
    {
        $orders = Order::with('items.product')->latest()->get();

        return view('admin.orders', compact('orders'));
    }

    // ADMIN: Update status
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated');
    }
}