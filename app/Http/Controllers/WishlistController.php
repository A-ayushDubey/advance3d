<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WishlistController extends Controller
{
    // SHOW WISHLIST PAGE
    public function index()
    {
        $wishlist = session()->get('wishlist', []);

        $products = Product::whereIn('id', array_keys($wishlist))->get();

        return view('wishlist', compact('products'));
    }

    // ADD / REMOVE
    public function toggle($id)
    {
        $wishlist = session()->get('wishlist', []);

        if(isset($wishlist[$id])){
            unset($wishlist[$id]);
            $status = 'removed';
        } else {
            $wishlist[$id] = true;
            $status = 'added';
        }

        session()->put('wishlist', $wishlist);

        return response()->json([
            'status' => $status,
            'count' => count($wishlist)
        ]);
    }
}