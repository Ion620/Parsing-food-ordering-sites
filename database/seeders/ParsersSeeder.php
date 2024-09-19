<?php

namespace Database\Seeders;

use App\Models\Parser;
use App\Parsers\MisteramGoodsParser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Parser::create([
             'class' => MisteramGoodsParser::class,
             'options' => '{}'
         ]);
    }
}
