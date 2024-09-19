<?php

namespace App\Tables;

use App\Models\Order;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;

class OrderTable extends AbstractTable
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
        return Order::query();
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
            ->column('number')
            ->column('created_at', 'date')
            ->column('total_Price')
            ->column('status')
            ->column('review')
            ->column('change_status')
            ->paginate(10);
    }
}
