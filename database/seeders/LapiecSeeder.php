<?php

namespace Database\Seeders;

use App\Models\Establishment;
use App\Models\Parser;
use App\Parsers\LapiecGoodsParser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LapiecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Establishment::query()->create([
            'name' => 'Lapiec',
            'url' => 'https://la.ua/chernivtsy/',
        ]);

        Parser::query()->create([
            'class' => LapiecGoodsParser::class,
            'options' => '{}'
        ]);
    }
}
