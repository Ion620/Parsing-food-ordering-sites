<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\GoodsController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ParserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstablishmentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('splade')->group(function () {
    // Registers routes to support password confirmation in Form and Link components...
    Route::spladePasswordConfirmation();

    // Registers routes to support Table Bulk Actions and Exports...
    Route::spladeTable();

    // Registers routes to support async File Uploads with Filepond...
    Route::spladeUploads();

    Route::get('/', function () {
        return view('welcome');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['verified'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    Route::group(['prefix' => '/goods'], function () {
        Route::get('/', [GoodsController::class, 'index'])->name('goods.index');
        Route::get('/create', [GoodsController::class, 'create'])->name('goods.create');
        Route::post('/create', [GoodsController::class, 'store'])->name('goods.store');
        Route::get('/edit/{id}', [GoodsController::class, 'edit'])->name('goods.edit');
        Route::post('/edit/{id}', [GoodsController::class, 'update'])->name('goods.update');
        Route::delete('/delete/{id}', [GoodsController::class, 'destroy'])->name('goods.destroy');
        Route::post('/plus/{id}', [GoodsController::class, 'plus'])->name('goods.plus');
        Route::post('/minus/{id}', [GoodsController::class, 'minus'])->name('goods.minus');
        Route::post('/add-to-cart/{id}', [GoodsController::class, 'addToCart'])->name('goods.addToCart');
        Route::post('/delete-from-cart/{id}', [GoodsController::class, 'deleteFromCart'])->name('goods.deleteFromCart');
    });
    Route::group(['prefix' => 'cart'], function (){
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/', [CartController::class, 'order'])->name('cart.order');
        Route::post('/plus/{id}', [CartController::class, 'plus'])->name('cart.plus');
        Route::post('/minus/{id}', [CartController::class, 'minus'])->name('cart.minus');
        Route::post('/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
        Route::post('/addToOrder', [CartController::class, 'addToOrder'])->name('cart.addToOrder');
    });
    Route::group(['prefix' => 'order'], function (){
        Route::get('/', [OrderController::class, 'index'])->name('order.index')->middleware('can:is_manager');
        Route::post('/change/{order}', [OrderController::class, 'changeStatus'])->name('order.change');
    });
    require __DIR__.'/auth.php';
});
Route::get('/parser', [ParserController::class, 'parser']);

Route::resource('establishments', EstablishmentController::class);

Route::get('images/{hash}', [ImageController::class, 'show'])->name('images.show');
