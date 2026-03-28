<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomOrder;
use Illuminate\Support\Facades\Auth;

class CustomOrderController extends Controller
{

    // Show form
    public function create()
    {
        return view('custom_order');
    }

    // Store request
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'file' => 'required|file|mimes:stl,obj,zip,jpg,png|max:10240',
        ]);

        $fileName = null;

        if($request->hasFile('file')){
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $request->file->move(public_path('custom_uploads'), $fileName);
        }

        CustomOrder::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'file' => $fileName,
            'description' => $request->description
        ]);

        return back()->with('success','Request submitted successfully!');
    }

    // Admin view
    public function adminIndex()
    {
        $orders = CustomOrder::latest()->get();

        return view('admin.custom_orders', compact('orders'));
    }
}