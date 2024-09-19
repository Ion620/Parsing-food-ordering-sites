<?php

namespace Tests\Unit;

use App\Actions\MinusGoodsInCart;
use App\Models\Cart;
use App\Models\Goods;
use App\Models\User;
use Tests\TestCase;
use Throwable;

class MinusGoodsInCartTest extends TestCase
{
    /**
     * @return void
     */
    public function test_Goods_Exist_and_Quantity_More_One() : void
    {
        $user  = User::factory()->create();
        $goods = Goods::factory()->create();
        $cart_factory = Cart::factory()->create([
            'customer_id' => $user->getKey(),
            'good_id'     => $goods->getKey(),
        ]);
        $minusGoodsInCart = (new MinusGoodsInCart());
        $minusGoodsInCart($goods->getKey(), $user->getKey());
        $cart = Cart::query()->findOrFail($cart_factory->getKey());
        $this->assertSame($cart_factory->quantity-1, $cart->quantity);
    }

    /**
     * @return void
     */
    public function test_Goods_Exist_and_Quantity_Less_One() : void
    {
        $user  = User::factory()->create();
        $goods = Goods::factory()->create();
        Cart::factory()->create([
            'customer_id' => $user->getKey(),
            'good_id'     => $goods->getKey(),
            'quantity'    => 1,
        ]);
        $minusGoodsInCart = (new MinusGoodsInCart());
        $minusGoodsInCart($goods->getKey(), $user->getKey());
        $cart = Cart::onlyTrashed()
            ->where('customer_id', '=', $user->getKey())
            ->where('good_id', '=', $goods->getKey())
            ->exists();
        $this->assertTrue($cart);
    }

    /**
     * @return void
     */
    public function test_User_Not_Exist() : void
    {
        $goods = Goods::factory()->create();
        $this->expectException(Throwable::class);
        $this->expectExceptionMessage('No query results for model');
        $minusGoodsInCart = (new MinusGoodsInCart());
        $minusGoodsInCart($goods->getKey(), PHP_INT_MAX);
    }

    /**
     * @return void
     */
    public function test_Goods_Not_Exist() : void
    {
        $user = User::factory()->create();
        $this->expectException(Throwable::class);
        $this->expectExceptionMessage('No query results for model');
        $minusGoodsInCart = (new MinusGoodsInCart());
        $minusGoodsInCart(PHP_INT_MAX, $user->getKey());
    }
}
