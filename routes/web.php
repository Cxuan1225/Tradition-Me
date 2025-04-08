<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\SwitchViewController;
use App\Livewire\Dashboard;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Landing Page
Route::get('/', function () {
    $products = Cache::remember('products_by_category', now()->addMinutes(30), function () {
        return Product::whereIn('category', ['Malay', 'Chinese', 'Indian'])
            ->with(['images' => function ($query) {
                $query->select('id', 'product_id', 'image_path');
            }])
            ->select('id', 'name', 'category', 'price')
            ->get()
            ->groupBy('category');
    });

    return view('welcome', [
        'malayProducts' => $products->get('Malay', collect()),
        'chineseProducts' => $products->get('Chinese', collect()),
        'indianProducts' => $products->get('Indian', collect())
    ]);
})->name('landing');



Route::post('/checkout.webhook', [StripeController::class, 'webhook'])->name('checkout.webhook');

//Dashboard route requiring authentication and email verification
Route::get(
    '/dashboard',
    Dashboard::class
)->middleware(['auth', 'verified', 'role:admin'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('product', ProductController::class);
});
Route::middleware(['auth'])->prefix('end_user')->name('end_user.')->group(function () {
    Route::get('/product/showCategory/{category}', [ProductController::class, 'showCategory'])->name('product.showCategory');
    Route::get('/product/showAll', [ProductController::class, 'showAll'])->name('product.showAll');
    Route::resource('product', ProductController::class);
    Route::resource('cart', CartController::class);
    Route::get('/checkout', [StripeController::class, 'index'])->name('checkout.index');
    Route::get('/checkout/success', [StripeController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [StripeController::class, 'cancel'])->name('checkout.cancel');
});

Route::middleware(['auth', 'role:end_user'])->group(function () {});

//Dashboard route requiring authentication
Route::middleware(['auth', 'role:admin,seller,end_user'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/preference', [ProfileController::class, 'updatePreference'])->name('profile.updatePreference');
    Route::post('/profile/address', [ProfileController::class, 'storeAddress'])->name('profile.createAddress');
    Route::put('/profile/address/{address}', [ProfileController::class, 'updateAddress'])->name('profile.updateAddress');
    Route::delete('/profile/address/{address}', [ProfileController::class, 'deleteAddress'])->name('profile.deleteAddress');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/image/update', [ImageController::class, 'updateProfileImage'])->name('image.update');
    Route::resource('order', OrderController::class);
    Route::get('/order/details/{order}', [OrderController::class, 'showDetails'])->name('order.details');
});
Route::get('/switch-view/{view}', [SwitchViewController::class, 'switchView'])->name('switch.view');

//Authentication using Laravel Breeze
require __DIR__ . '/auth.php';
