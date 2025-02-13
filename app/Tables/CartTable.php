<?php

namespace App\Tables;

use App\Models\Cart;
use App\Models\Enums\CartStatus;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;

class CartTable extends AbstractTable
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user is authorized to perform bulk actions and exports.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        return true;
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for()
    {
        return Cart::query()
            ->where('customer_id', '=', Auth()->id())
            ->where('status', '=', CartStatus::IN_PROCESS->value);
    }

    /**
     * Configure the given SpladeTable.
     *
     * @param \ProtoneMedia\Splade\SpladeTable $table
     * @return void
     */
    public function configure(SpladeTable $table)
    {
        $table
            ->defaultSort('created_at')
            ->column('customer')
            ->column('establishment')
            ->column('good')
            ->column('quantity')
            ->column('status')
            ->column('price')
            ->column('delete')
            ->paginate(10);
    }
}
