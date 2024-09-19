<?php

namespace App\Http\Controllers;

use App\Models\Action\ParserGoods;

/**
 * @deprecated For manual test only
 */
class ParserController extends Controller
{
    /**
     * @phpstan-ignore-next-line
     */
    public function parser()
    {
        /**
         * @phpstan-ignore-next-line
         */
        return (new ParserGoods())->parser();
    }
}
