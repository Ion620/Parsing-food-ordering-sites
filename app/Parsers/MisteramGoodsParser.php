<?php

namespace App\Parsers;

use App\DTOs\ParserGoodsDTO;
use App\Models\Enums\GoodsStatus;
use App\Models\Images;
use Exception;
use HeadlessChromium\BrowserFactory;
use Illuminate\Support\Collection;

/**
 * @todo need fix this
 */
class MisteramGoodsParser implements Parser
{
    /**
     * @throws Exception
     */
    public function parse($url, $options = []): Collection
    {
        $browserFactory = new BrowserFactory();
        $browser = $browserFactory->createBrowser([
            'windowSize' => [1920, 1000],
        ]);
        $page = $browser->createPage();
        $page->navigate($url)->waitForNavigation();

        $links = $page->dom()->search('//*[@id="cats"]/div/div/div/div/a');

        $collection = collect();
        foreach ($links as $link) {
            $collection->push($this->parseLink($browser, $link));
        }

        return $collection;
    }

    /** @phpstan-ignore-next-line */
    private function parseLink($browser, $link)
    {
        $category_link = $link->getAttribute('href');
        $category = $link->getText();
        $page = $browser->createPage();
        $page->navigate('https://misteram.com.ua'.$category_link)->waitForNavigation();
        $height = $page->evaluate('document.body.scrollTop = document.body.scrollHeight;')->getReturnValue();
        $page->mouse()->scrollDown($height);
        sleep(1);
        $page->evaluate("var res = document.documentElement.getElementsByClassName('hoverable');");
        $count_goods = $page->evaluate('res.length')->getReturnValue();

        $dto = collect();
        for ($i = 0; $i < $count_goods; $i++) {
            $dto->push($this->parseGoods($page, $i, $category));
        }

        return $dto;
    }

    /** @phpstan-ignore-next-line */
    private function parseGoods($page, $i, $category)
    {
        $page->evaluate("res[$i].click();");
        sleep(1);
        $name = $page->dom()->search('//*[@class="simplebar-content"]/div/p')[0]->getText();
        $description = $page->dom()->search('//*[@class="simplebar-content"]/div/p')[1]->getText();
        $price = (int)explode(
            ' ',
            $page->dom()
                ->search('//*[@class="simplebar-wrapper"]/../../div[2]/div/p')[0]->getText()
        )[0];
        $status = $page->dom()
                      ->search('//*[@class="simplebar-wrapper"]/../../div[2]/div[3]/button')[0]
            ->getAttribute('disabled');
        $status_value = is_null($status) ? GoodsStatus::AVAILABLE->value : GoodsStatus::UNAVAILABLE->value;
        $weight = $page->dom()->search('//*[@class="simplebar-content"]/div/p')[2]->getText();
        $data = json_encode(['weight' => $weight]);

        $image = $page->dom()->search('//*[@class="simplebar-content"]/div/img');

        $hash = Images::query()->where('path', '=', 'images/image_not_available.png')->first()->hash;
        if (!$image) {
            $image = route('images.show', ['hash' => $hash]);
        } else {
            $image = $image[0]->getAttribute('src');
        }
        $page->dom()->search('//*[@class="simplebar-wrapper"]/../../button')[0]->click();
        sleep(1);

        return new ParserGoodsDTO($name, $description, $price, $status_value, $category, $data, $image);
    }
}
