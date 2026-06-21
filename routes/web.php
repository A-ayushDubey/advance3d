<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomOrderController;
use App\Http\Controllers\PaymentController;
use App\Models\Cart;

Route::post('/payment/verify', [PaymentController::class, 'verify'])
    ->name('payment.verify');

/*
|--------------------------------------------------------------------------
| Home Page
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Product Pages (Customer)
|--------------------------------------------------------------------------
*/

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

/*
|--------------------------------------------------------------------------
| Cart System
|--------------------------------------------------------------------------
*/

Route::get('/cart', [CartController::class,'index'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class,'add'])->name('cart.add');
Route::get('/cart/items', [CartController::class,'getCartItems'])->name('cart.items');
Route::post('/cart/update/{id}', [CartController::class,'update'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class,'remove'])->name('cart.remove');
Route::post('/cart/remove/{id}', [CartController::class,'remove'])->name('cart.remove');

/*
|--------------------------------------------------------------------------
| Wishlist (Auth Required)
|--------------------------------------------------------------------------
*/
Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist');

// Route::middleware('auth')->group(function () {
//     Route::post('/wishlist/toggle/{id}', [WishlistController::class,'toggle'])
//         ->name('wishlist.toggle');
// });

/*
|--------------------------------------------------------------------------
| Rating (Auth Required)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::post('/rating/{id}', [RatingController::class,'store'])
        ->name('rating.store');
});

/*
|--------------------------------------------------------------------------
| Admin Product Management (PROTECTED)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/products', [ProductController::class,'adminIndex'])
        ->name('admin.products');

    Route::get('/products/create', [ProductController::class,'create'])
        ->name('admin.products.create');

    Route::post('/products/store', [ProductController::class,'store'])
        ->name('admin.products.store');

    Route::get('/products/edit/{id}', [ProductController::class,'edit'])
        ->name('admin.products.edit');

    Route::post('/products/update/{id}', [ProductController::class,'update'])
        ->name('admin.products.update');

    Route::get('/products/delete/{id}', [ProductController::class,'delete'])
        ->name('admin.products.delete');

});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Auth::routes();

/*
|--------------------------------------------------------------------------
| Redirect after login
|--------------------------------------------------------------------------
*/

Route::get('/home', [HomeController::class, 'index'])->name('home');




Route::middleware('auth')->group(function () {

    Route::get('/checkout', [OrderController::class,'checkout'])->name('checkout');

    Route::post('/place-order', [OrderController::class,'placeOrder'])->name('place.order');

});
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/orders', [OrderController::class,'adminOrders'])
        ->name('admin.orders');

    Route::post('/orders/update/{id}', [OrderController::class,'updateStatus'])
        ->name('admin.orders.update');

});



/* CUSTOMER */

Route::get('/custom-order', [CustomOrderController::class,'create'])->name('custom.order');

Route::post('/custom-order', [CustomOrderController::class,'store'])->name('custom.order.store');


/* ADMIN */

Route::middleware(['auth','admin'])->prefix('admin')->group(function(){

    Route::get('/custom-orders', [CustomOrderController::class,'adminIndex'])
        ->name('admin.custom.orders');

});

Route::get('/dashboard', [HomeController::class, 'adminDashboard'])
    ->name('admin.dashboard');

    Route::delete('/admin/delete-image/{id}', [ProductController::class, 'deleteImage']);

    Route::post('/admin/set-main-image/{id}', [ProductController::class,'setMainImage']);
Route::post('/admin/update-image-order', [ProductController::class,'updateImageOrder']);
Route::post('/admin/delete-multiple-images', [ProductController::class,'deleteMultipleImages']);
// Route::post('/wishlist/toggle/{id}', [WishlistController::class, 'toggle']);
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist/toggle/{id}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
// Route::get('/cart/items', [CartController::class, 'getCartItems']);
// Route::get('/cart/items', function () {

//     if (Auth::check()) {
//         return Cart::with('product')
//             ->where('user_id', Auth::id())
//             ->get()
//             ->map(function ($item) {
//                 return [
//                     'name' => $item->product->name,
//                     'price' => $item->product->price,
//                     'image' => $item->product->image,
//                     'quantity' => $item->quantity,
//                 ];
//             });
//     }

//     return session('cart', []);
// });

Route::middleware('auth')->group(function () {

    Route::get('/my-orders', [OrderController::class, 'myOrders'])
        ->name('orders.my');

    Route::get('/order/{id}', [OrderController::class, 'show'])
        ->name('orders.show');

});
// Route::get('/admin/dashboard', [OrderController::class, 'adminDashboard'])
//     ->name('admin.dashboard');

Route::post('/admin/orders/delete/{id}', [OrderController::class, 'deleteOrder'])
    ->name('admin.orders.delete');