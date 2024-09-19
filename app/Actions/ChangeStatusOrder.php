<?php

namespace App\Actions;

use App\Models\Enums\OrderStatus;
use App\Models\Order;

class ChangeStatusOrder
{
    /**
     * @param Order $order
     * @return void
     */
    public function __invoke(Order $order) : void
    {
        $order->status == OrderStatus::OPEN->value
            ? $order->update(['status' => OrderStatus::IN_PROCESS->value])
            : $order->update(['status' => OrderStatus::COMPLETED->value]);
    }
}
