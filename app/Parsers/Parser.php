<?php

namespace App\Parsers;

use App\DTOs\ParserGoodsDTO;
use Illuminate\Support\Collection;

interface Parser
{
    /**
     * @param  string  $url
     * @param  array<string, mixed>  $options
     *
     * @return Collection<int, ParserGoodsDTO>
     */
    public function parse(string $url, array $options = []): Collection;
}
