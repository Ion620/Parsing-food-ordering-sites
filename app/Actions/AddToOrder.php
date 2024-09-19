<?php

namespace App\Actions;

use App\Models\Cart;
use App\Models\Enums\CartStatus;
use App\Models\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderGood;
use App\Models\User;
use Carbon\Carbon;

use function PHPUnit\Framework\throwException;

class AddToOrder
{
    public function __invoke(int $customerId): void
    {
       User::query()->findOrFail($customerId);

        $carts = Cart::query()
            ->where('customer_id', '=', $customerId)
            ->get();

        $today = Carbon::now();
        $order = Order::query()->firstOrCreate(
            [
                'establishment_id' => 1,
                'status'           => OrderStatus::OPEN,
            ],
            [
                'number'     => $today->year.$today->week.mt_rand(10000000,99999999),
                'manager_id' => $customerId
            ]);

        foreach ($carts as $cart) {
            OrderGood::query()->updateOrCreate([
                'customer_id' => $customerId,
                'order_id'    => $order->getKey(),
                'good_id'     => $cart->good_id,
            ],[
                'price'    => $cart->good->price,
                'quantity' => $cart->quantity,
                'quantity_type'  => '',
                'final_quantity' => 0,
                'total_price'    => 0,
            ]);
            $cart->update(['status' => CartStatus::COMPLETED->value]);
        }
    }
}
