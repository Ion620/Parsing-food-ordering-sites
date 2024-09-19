<?php

namespace App\Http\Controllers;

use App\Actions\ChangeStatusOrder;
use App\Models\Order;
use App\Tables\OrderTable;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index() : View
    {
        return view('order.index', [
            'orders' => OrderTable::class,
        ]);
    }

    /**
     * @param ChangeStatusOrder $changeStatusOrder
     * @param Order $order
     * @return RedirectResponse
     */
    public function changeStatus(ChangeStatusOrder $changeStatusOrder, Order $order) : RedirectResponse
    {
        $changeStatusOrder($order);
        return redirect()->route('order.index');
    }
}
