<?php

namespace Tests\Unit;

use App\Actions\AddGoodsToCart;
use App\Models\Cart;
use App\Models\Enums\CartStatus;
use App\Models\Goods;
use Tests\TestCase;
use Throwable;

class AddGoodsToCartTest extends TestCase
{
    /**
     * @return void
     */
    public function test_If_Exists_Goods_and_Customer() : void
    {
        $goods = Goods::factory()->create();
        $addGoodsToCart = (new AddGoodsToCart());
        $addGoodsToCart($goods->getKey(), 1);
        $cart = Cart::query()->where([
            'good_id'     => $goods->getKey(),
            'customer_id' => 1,
        ])->firstOrFail();
        $this->assertSame(1, $cart->quantity);
        $this->assertSame(CartStatus::IN_PROCESS, $cart->status);
    }

    /**
     * @return void
     */
    public function test_If_not_Exists_Goods() : void
    {
        $this->expectException(Throwable::class);
        $this->expectExceptionMessage('foreign key constraint fails');
        $addGoodsToCart = (new AddGoodsToCart());
        $addGoodsToCart(PHP_INT_MAX, 1);
    }

    /**
     * @return void
     */
    public function test_If_not_Exists_Customer() : void
    {
        $this->expectException(Throwable::class);
        $this->expectExceptionMessage('foreign key constraint fails');
        $addGoodsToCart = (new AddGoodsToCart());
        $addGoodsToCart(3, PHP_INT_MAX);
    }
}
