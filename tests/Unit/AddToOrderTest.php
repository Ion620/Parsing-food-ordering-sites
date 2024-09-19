<?php

namespace Tests\Unit;

use App\Actions\AddToOrder;
use App\Models\Cart;
use App\Models\Enums\OrderStatus;
use App\Models\Goods;
use App\Models\Order;
use App\Models\OrderGood;
use App\Models\User;
use Tests\TestCase;
use Throwable;

class AddToOrderTest extends TestCase
{
    /**
     * @return void
     */
    public function test_User_Exists_and_Exists_Order() : void
    {
        Order::query()->each(function ($order) {
           $order->update(['status' => OrderStatus::IN_PROCESS]);
        });
        $user = User::factory()->create();
        Goods::factory()
            ->count(3)
            ->create()->each(function ($goods) use ($user) {
                Cart::factory()
                    ->count(3)
                    ->create([
                        'customer_id' => $user->getKey(),
                        'good_id'     => $goods->getKey()
                    ]);
            });
        $order = Order::factory()->create();
        $addGoodsToCart = (new AddToOrder());
        $addGoodsToCart($user->getKey());
        $count = OrderGood::query()->where('order_id', '=', $order->getKey())->count();
        $this->assertSame(3, $count);
    }

    /**
     * @return void
     */
    public function test_User_Exists_and_Not_Order() : void
    {
        Order::query()->each(function ($order) {
           $order->update(['status' => OrderStatus::IN_PROCESS]);
        });
        $user = User::factory()->create();
        Goods::factory()
            ->count(3)
            ->create()->each(function ($goods) use ($user) {
                Cart::factory()
                    ->count(3)
                    ->create([
                        'customer_id' => $user->getKey(),
                        'good_id'     => $goods->getKey()
                    ]);
            });
        $addGoodsToCart = (new AddToOrder());
        $addGoodsToCart($user->getKey());
        $order = Order::query()->latest()->first();
        $count = OrderGood::query()->where('order_id', '=', $order->getKey())->count();
        $this->assertSame(3, $count);
    }

    /**
     * @return void
     */
    public function test_User_Exists_and_Not_Goods_In_Cart() : void
    {
        $user = User::factory()->create();
        Order::query()->each(function ($order) {
           $order->update(['status' => OrderStatus::IN_PROCESS]);
        });
        $addGoodsToCart = (new AddToOrder());
        $addGoodsToCart($user->getKey());
        $order = Order::query()
            ->where('status', '=', OrderStatus::OPEN->value)
            ->first();
        $count = OrderGood::query()->where('order_id', '=', $order->getKey())->count();
        $this->assertSame(0, $count);
    }

    /**
     * @return void
     */
    public function test_User_Not_Found() : void
    {
        $this->expectException(Throwable::class);
        $this->expectExceptionMessage('No query results for model');
        $addGoodsToCart = (new AddToOrder());
        $addGoodsToCart(PHP_INT_MAX);
    }
}
