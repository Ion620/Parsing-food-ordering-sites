<?php

namespace App\Actions;

use App\Models\Cart;
use App\Models\Enums\CartStatus;

class AddGoodsToCart
{
    public function __invoke(int $goodId, int $customerId): void
    {
        Cart::query()->create(
                [
                    'customer_id' => $customerId,
                    'good_id'     => $goodId,
                    'status'      => CartStatus::IN_PROCESS->value,
                    'quantity'    => 1,
                ],
            );
    }
}
