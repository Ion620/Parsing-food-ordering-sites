<?php

namespace Database\Seeders;

use App\Models\Parser;
use App\Models\Source;
use App\Service\ParserService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Parser::create([
            'class' => ParserService::class,
            'options' => '{}'
        ]);

        $misteram = [
            'name' => 'misteram',
            'url'  => 'https://misteram.com.ua/chernivtsi'
        ];
        $glovo = [
            'name' => 'glovo',
            'url'  => 'https://glovoapp.com/ua/uk/chernivtsi/'
        ];
        $establishments = [$misteram, $glovo];
        foreach ($establishments as $establishment) {
            Source::query()->create([
                'name' => $establishment['name'],
                'url'  => $establishment['url'],
                'data' => '',
            ]);
        }
    }
}
