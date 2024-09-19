<?php

namespace App\Parsers;

use App\Models\Establishment;
use Exception;
use HeadlessChromium\BrowserFactory;

class GlovoEstablishmentsParser
{
    /**
     * @param  string  $url
     *
     * @return void
     * @throws Exception
     */
    public function parser(string $url): void
    {
        $browserFactory = new BrowserFactory();
        $browser = $browserFactory->createBrowser([
            'windowSize' => [1920, 1000],
        ]);
        $page = $browser->createPage();
        $page->navigate($url)->waitForNavigation();

        $page->dom()->querySelector('.category-bubble__link')->click();
        sleep(1);

        $links = $page->dom()->querySelectorAll('.store-card');
        $establishments = [];
        foreach ($links as $link) {
            $establishment['name'] = trim($link->querySelector('.card-title')->getText());
            $establishment['url'] = 'https://glovoapp.com'.$link->querySelector('a')->getAttribute('href');
            $establishments[] = $establishment;
        }
        $this->createEstablishments($establishments);
    }

    /**
     * @param  array<array<string, mixed>>  $establishments
     *
     * @return void
     */
    public function createEstablishments(array $establishments): void
    {
        foreach ($establishments as $establishment) {
            Establishment::query()->updateOrCreate([
                'url' => $establishment['url'],
            ], [
                'name' => $establishment['name'],
            ]);
        }
    }
}
