<?php

namespace Tests\Unit;

use App\Actions\PlusGoodsToCart;
use App\Models\Cart;
use App\Models\Goods;
use App\Models\User;
use Tests\TestCase;
use Throwable;

class PlusGoodsToCartTest extends TestCase
{
    /**
     * @return void
     */
    public function test_Goods_Exist() : void
    {
        $user  = User::factory()->create();
        $goods = Goods::factory()->create();
        $cart_factory = Cart::factory()->create([
            'customer_id' => $user->getKey(),
            'good_id'     => $goods->getKey()
        ]);
        $plusGoodsToCart = (new PlusGoodsToCart());
        $plusGoodsToCart($goods->getKey(), $user->getKey());
        $cart = Cart::query()->findOrFail($cart_factory->getKey());
        $this->assertSame($cart_factory->quantity+1, $cart->quantity);
    }

    /**
     * @return void
     */
    public function test_User_Not_Exist() : void
    {
        $goods = Goods::factory()->create();
        $this->expectException(Throwable::class);
        $this->expectExceptionMessage('foreign key constraint fails');
        $plusGoodsToCart = (new PlusGoodsToCart());
        $plusGoodsToCart($goods->getKey(), PHP_INT_MAX);
    }

    /**
     * @return void
     */
    public function test_Goods_Not_Exist() : void
    {
        $user = User::factory()->create();
        $this->expectException(Throwable::class);
        $this->expectExceptionMessage('foreign key constraint fails');
        $plusGoodsToCart = (new PlusGoodsToCart());
        $plusGoodsToCart(PHP_INT_MAX, $user->getKey());
    }
}
