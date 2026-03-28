<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    /* =========================
       ADD TO CART (AJAX)
    ========================= */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if(isset($cart[$id])){
            $cart[$id]['quantity'] += $request->quantity ?? 1;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "price" => $product->price,
                "image" => $product->image,
                "quantity" => $request->quantity ?? 1
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cartCount' => count($cart)
        ]);
    }


    /* =========================
       GET CART ITEMS (SIDEBAR)
    ========================= */
    public function getCartItems()
    {
        return response()->json(session('cart', []));
    }


    /* =========================
       UPDATE CART
    ========================= */
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])){
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart');
    }


    /* =========================
       REMOVE ITEM
    ========================= */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])){
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart');
    }


    /* =========================
       SHOW CART PAGE
    ========================= */
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }
}