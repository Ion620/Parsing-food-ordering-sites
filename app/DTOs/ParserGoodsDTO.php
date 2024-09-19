<?php

namespace App\DTOs;

class ParserGoodsDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly int $price,
        public readonly string $status,
        public readonly string $category,
        public readonly string $data,
        public readonly string $image,
    ) {
    }
}
