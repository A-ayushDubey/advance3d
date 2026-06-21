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

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']); // ADD THIS

        return view('checkout', compact('cart', 'total')); // ADD 'total' here
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
            'address' => 'required',
            'payment_method' => 'required'
        ]);

        $total = 0;

        foreach($cart as $item){
            $total += $item['price'] * $item['quantity'];
        }

        // ✅ CREATE ORDER FIRST
        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'total' => $total,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
        ]);

       // SAVE ITEMS
        foreach($cart as $id => $item){
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }


        // ================= PAYMENT LOGIC =================

        // COD
        if($request->payment_method == 'cod'){
            session()->forget('cart');

            return redirect()->route('orders.my')
                ->with('success','Order placed successfully!');
        }

        // 🔥 👉 PASTE YOUR CODE HERE (UPI)
        if($request->payment_method == 'upi'){
            return redirect()->route('orders.show', $order->id)
                ->with('upi', true);
        }

        // Razorpay
        if($request->payment_method == 'razorpay'){
            return response()->json([
                'order_id' => $order->id,
                'amount' => $total
            ]);
        }
    }
    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);

        // Optional: delete items also
        $order->items()->delete();

        $order->delete();

        return back()->with('success', 'Order deleted successfully');
    }

    // ADMIN: View all orders
    public function adminOrders(Request $request)
    {
        $query = Order::with('items.product');

        // 🔍 SEARCH (id, name, phone)
        if($request->search){
            $query->where(function($q) use ($request){
                $q->where('id', $request->search)
                ->orWhere('name', 'like', '%'.$request->search.'%')
                ->orWhere('phone', 'like', '%'.$request->search.'%');
            });
        }

        // 🎯 STATUS FILTER
        if($request->status){
            $query->where('status', $request->status);
        }

        // 📅 DATE FILTER
        if($request->date){
            $query->whereDate('created_at', $request->date);
        }

        // ✅ PAGINATION
        $orders = $query->latest()->paginate(10);

        // 📊 STATS (OPTIONAL)
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status','paid')->sum('total');
        $pendingOrders = Order::where('status','pending')->count();
        $deliveredOrders = Order::where('status','delivered')->count();

        return view('admin.orders', compact(
            'orders',
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'deliveredOrders'
        ));
    }
    // ADMIN: Update status
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated');
    }
    // ================= CUSTOMER: MY ORDERS =================
        public function myOrders()
        {
            $orders = Order::where('user_id', Auth::id())
                            ->latest()
                            ->get();

            return view('orders.index', compact('orders'));
        }


        // ================= CUSTOMER: TRACK ORDER =================
        public function show($id)
        {
            $order = Order::with('items.product')
                        ->where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

            return view('orders.show', compact('order'));
}

// public function adminDashboard(Request $request)
// {
//     $query = Order::with('items.product');

//     // 🔍 SEARCH
//     if($request->search){
//         $query->where('id', $request->search)
//               ->orWhere('name', 'like', '%'.$request->search.'%')
//               ->orWhere('phone', 'like', '%'.$request->search.'%');
//     }

//     // 🎯 FILTER STATUS
//     if($request->status){
//         $query->where('status', $request->status);
//     }

//     // 📅 FILTER DATE
//     if($request->date){
//         $query->whereDate('created_at', $request->date);
//     }

//     $orders = $query->latest()->paginate(10);

//     // 📊 STATS
//     $totalOrders = Order::count();
//     $totalRevenue = Order::where('payment_status','paid')->sum('total');
//     $pendingOrders = Order::where('status','pending')->count();
//     $deliveredOrders = Order::where('status','delivered')->count();

//     return view('admin.dashboard', compact(
//         'orders',
//         'totalOrders',
//         'totalRevenue',
//         'pendingOrders',
//         'deliveredOrders'
//     ));
// }
}