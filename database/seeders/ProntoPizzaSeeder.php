<?php

namespace Database\Seeders;

use App\Models\Establishment;
use App\Models\Parser;
use App\Parsers\ProntoPizzaGoodsParser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProntoPizzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Establishment::query()->create([
            'name' => 'ProntoPizza',
            'url' => 'https://prontopizza.ua/chernivtsi/',
        ]);

        Parser::query()->create([
            'class' => ProntoPizzaGoodsParser::class,
            'options' => '{}'
        ]);
    }
}
