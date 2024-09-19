<?php

namespace App\Service;

use App\Models\Establishment;
use Symfony\Component\DomCrawler\Crawler;

class ParserService
{
    public function parser(string $url): void
    {
        $html = file_get_contents($url);
        $crawler = new Crawler($html);
        $names = $crawler->filter('p.css-160pmq1');

        foreach ($names as $name) {
            Establishment::query()->updateOrCreate(['name' => $name->textContent]);
        }
    }
}
