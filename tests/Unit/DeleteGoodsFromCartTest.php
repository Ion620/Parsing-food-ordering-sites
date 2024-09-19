<?php

namespace Tests\Unit;

use App\Actions\DeleteGoodsFromCart;
use App\Models\Cart;
use App\Models\Goods;
use App\Models\User;
use Tests\TestCase;
use Throwable;

class DeleteGoodsFromCartTest extends TestCase
{
    /**
     * @return void
     */
    public function test_Goods_Exists() : void
    {
        $user  = User::factory()->create();
        $goods = Goods::factory()->create();
        Cart::factory()->create([
            'customer_id' => $user->getKey(),
            'good_id'     => $goods->getKey()
        ]);
        $deleteGoodsFromCart = (new DeleteGoodsFromCart());
        $deleteGoodsFromCart($goods->getKey(), $user->getKey());
        $cart = Cart::onlyTrashed()
            ->where('customer_id', '=', $user->getKey())
            ->where('good_id', '=', $goods->getKey())
            ->exists();
        $this->assertTrue($cart);
    }

    /**
     * @return void
     */
    public function test_Goods_not_Exists() : void
    {
        $user = User::factory()->create();
        $this->expectException(Throwable::class);
        $this->expectExceptionMessage('No query results for model');
        $deleteGoodsFromCart = (new DeleteGoodsFromCart());
        $deleteGoodsFromCart(PHP_INT_MAX, $user->getKey());
    }

    /**
     * @return void
     */
    public function test_User_not_Exists() : void
    {
        $goods = Goods::factory()->create();
        $this->expectException(Throwable::class);
        $this->expectExceptionMessage('No query results for model');
        $deleteGoodsFromCart = (new DeleteGoodsFromCart());
        $deleteGoodsFromCart($goods->getKey(), PHP_INT_MAX);
    }

    /**
     * @return void
     */
    public function test_Goods_From_Cart_Already_Delete() : void
    {
        $user  = User::factory()->create();
        $goods = Goods::factory()->create();
        $cart = Cart::factory()->create([
            'customer_id' => $user->getKey(),
            'good_id'     => $goods->getKey()
        ]);
        $cart->delete();
        $this->expectException(Throwable::class);
        $this->expectExceptionMessage('No query results for model');
        $deleteGoodsFromCart = (new DeleteGoodsFromCart());
        $deleteGoodsFromCart($goods->getKey(), $user->getKey());
    }
}
