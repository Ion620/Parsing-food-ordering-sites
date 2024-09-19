<?php

namespace App\Http\Controllers;

use App\Actions\AddToOrder;
use App\Actions\DeleteGoodsFromCart;
use App\Actions\MinusGoodsInCart;
use App\Actions\PlusGoodsToCart;
use App\Models\Cart;
use App\Tables\CartTable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index() : View
    {
        $carts = Cart::query()
            ->where('customer_id', '=', Auth()->id())
            ->get();
        $sum = [];
        foreach ($carts as $cart) {
            $sum[] = $cart->price();
        }
        return view('cart.index', [
            'cart'      => CartTable::class,
            'total_sum' => array_sum($sum),
        ]);
    }

    /**
     * @param  PlusGoodsToCart  $plusGoodsToCart
     * @param  int  $id
     *
     * @return RedirectResponse
     */
    public function plus(PlusGoodsToCart $plusGoodsToCart, int $id): RedirectResponse
    {
        try {
            $plusGoodsToCart($id, Auth::id());
        } catch (\Throwable $e) {
            Session::put('error', $e->getMessage());
        }

        return redirect()->route('cart.index');
    }

    /**
     * @param  MinusGoodsInCart  $minusGoodsInCart
     * @param  int  $id
     *
     * @return RedirectResponse
     */
    public function minus(MinusGoodsInCart $minusGoodsInCart, int $id): RedirectResponse
    {
        try {
            $minusGoodsInCart($id, Auth::id());
        } catch (\Throwable $e) {
            Session::put('error', $e->getMessage());
        }

        return redirect()->route('cart.index');
    }

    /**
     * @param DeleteGoodsFromCart $deleteGoodsFromCart
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function delete(DeleteGoodsFromCart $deleteGoodsFromCart, int $id): RedirectResponse
    {
        try {
            $deleteGoodsFromCart($id, Auth()->id());
        } catch (\Throwable $e) {
            Session::put('error', $e->getMessage());
        }

        return redirect()->route('cart.index');
    }

    /**
     * @param AddToOrder $addToOrder
     * @return RedirectResponse
     */
    public function addToOrder(AddToOrder $addToOrder): RedirectResponse
    {
        try {
            $addToOrder(Auth()->id());
        } catch (\Throwable $e) {
            Session::put('error', $e->getMessage());
        }
        return redirect()->route('cart.index');
    }
}
