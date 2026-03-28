<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;

class ProductController extends Controller
{

/* ===============================
   CUSTOMER PAGES
================================ */

public function index(Request $request)
{
    $query = Product::query();

    if($request->search){
        $query->where('name','like','%'.$request->search.'%');
    }

    if($request->category){
        $query->where('category',$request->category);
    }

    if($request->sort == "low"){
        $query->orderBy('price','asc');
    }
    elseif($request->sort == "high"){
        $query->orderBy('price','desc');
    }
    else{
        $query->latest();
    }

    $products = $query->paginate(20);

    return view('products', compact('products'));
}

public function show($id)
{
    $product = Product::with(['images' => function($q){
        $q->orderBy('position','asc');
    }])->findOrFail($id);

    $related = Product::where('category',$product->category)
                    ->where('id','!=',$product->id)
                    ->take(4)
                    ->get();

    return view('product_details', compact('product','related'));
}


/* ===============================
   ADMIN PAGES
================================ */

public function adminIndex()
{
    $products = Product::with(['images' => function($q){
        $q->orderBy('position','asc');
    }])->latest()->paginate(10);

    return view('admin.products', compact('products'));
}

public function create()
{
    return view('admin.create_product');
}


/* ===============================
   STORE MULTIPLE PRODUCTS
================================ */

public function store(Request $request)
{
    if(!$request->products){
        return back()->with('error','No products added');
    }

    foreach($request->products as $index => $productData){

        if(empty($productData['name'])) continue;

        $uploadedImages = [];

        // ✅ FIX: get images properly
        if($request->hasFile("products.$index.images")){

            foreach($request->file("products.$index.images") as $key => $file){

                if(!$file) continue;

                $imgName = time().'_'.$index.'_'.$key.'_'.uniqid().'.'.$file->extension();

                $file->move(public_path('product_images'), $imgName);

                $uploadedImages[] = $imgName;
            }
        }

        // ❗ Skip if no image (avoid DB error)
        if(empty($uploadedImages)){
            continue;
        }

        $mainImage = $uploadedImages[0];

        // Create product
        $product = Product::create([
            'name' => $productData['name'],
            'description' => $productData['description'] ?? '',
            'price' => $productData['price'],
            'category' => $productData['category'],
            'stock' => $productData['stock'],
            'image' => $mainImage
        ]);

        // Save images
        foreach($uploadedImages as $img){
            $product->images()->create([
                'image' => $img
            ]);
        }
    }

    return redirect()->route('admin.products')->with('success','Products uploaded successfully');
}


/* ===============================
   EDIT PRODUCT
================================ */

public function edit($id)
{
    $product = Product::with(['images' => function($q){
        $q->orderBy('position','asc');
    }])->findOrFail($id);

    return view('admin.edit_product', compact('product'));
}


/* ===============================
   UPDATE PRODUCT
================================ */

public function update(Request $request, $id)
{
    $product = Product::with('images')->findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'category' => 'required|string|max:255',
        'stock' => 'required|integer|min:0',
        'description' => 'nullable|string',
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:4096'
    ]);

    $product->update([
        'name' => $request->name,
        'description' => $request->description ?? '',
        'price' => $request->price,
        'category' => $request->category,
        'stock' => $request->stock
    ]);

    // ADD NEW IMAGES
    if($request->hasFile('images')){

        $currentCount = $product->images()->count();

        foreach($request->file('images') as $index => $file){

            if(!$file) continue;

            $imageName = uniqid().'_'.time().'_'.$file->getClientOriginalName();

            $file->move(public_path('product_images'), $imageName);

            $product->images()->create([
                'image' => $imageName,
                'position' => $currentCount + $index
            ]);
        }
    }

    // ensure main image exists
    if(!$product->image){
        $firstImage = $product->images()->orderBy('position')->first();
        if($firstImage){
            $product->image = $firstImage->image;
            $product->save();
        }
    }

    return redirect('/admin/products')->with('success','Product updated successfully');
}


/* ===============================
   DELETE PRODUCT
================================ */

public function delete($id)
{
    $product = Product::with('images')->findOrFail($id);

    foreach($product->images as $img){
        @unlink(public_path('product_images/'.$img->image));
        $img->delete();
    }

    @unlink(public_path('product_images/'.$product->image));

    $product->delete();

    return redirect('/admin/products')->with('success','Product deleted successfully');
}


/* ===============================
   DELETE SINGLE IMAGE
================================ */

public function deleteImage($id)
{
    $image = ProductImage::findOrFail($id);
    $product = $image->product;

    @unlink(public_path('product_images/'.$image->image));

    $image->delete();

    // FIX main image
    if($product->image == $image->image){
        $newMain = $product->images()->orderBy('position')->first();
        $product->image = $newMain ? $newMain->image : null;
        $product->save();
    }

    return response()->json(['success' => true]);
}


/* ===============================
   IMAGE MANAGER PRO
================================ */

// SET MAIN IMAGE
public function setMainImage($id)
{
    $image = ProductImage::findOrFail($id);
    $product = $image->product;

    $product->image = $image->image;
    $product->save();

    return response()->json(['success'=>true]);
}


// UPDATE ORDER
public function updateImageOrder(Request $request)
{
    foreach($request->order as $item){
        ProductImage::where('id',$item['id'])
            ->update(['position'=>$item['position']]);
    }

    return response()->json(['success'=>true]);
}


// BULK DELETE
public function deleteMultipleImages(Request $request)
{
    foreach($request->ids as $id){

        $image = ProductImage::find($id);
        if(!$image) continue;

        $product = $image->product;

        @unlink(public_path('product_images/'.$image->image));

        $image->delete();

        // FIX main image
        if($product->image == $image->image){
            $newMain = $product->images()->orderBy('position')->first();
            $product->image = $newMain ? $newMain->image : null;
            $product->save();
        }
    }

    return response()->json(['success'=>true]);
}

}