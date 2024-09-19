<?php

namespace App\Parsers;

use App\DTOs\ParserGoodsDTO;
use App\Models\Enums\GoodsStatus;
use App\Models\Images;
use Exception;
use HeadlessChromium\BrowserFactory;
use HeadlessChromium\Dom\Node;
use HeadlessChromium\Exception\CommunicationException;
use HeadlessChromium\Page;
use Illuminate\Support\Collection;

/**
 * @todo need fix this
 */
class GlovoGoodsParser implements Parser
{
    /**
     * @param  string  $url
     * @param  array  $options
     *
     * @return Collection
     * @throws Exception
     * @phpstan-ignore-next-line
     */
    public function parse(string $url, array $options = []): Collection
    {
        $browserFactory = new BrowserFactory();
        $browser = $browserFactory->createBrowser([
            'windowSize' => [1920, 1000],
        ]);
        $page = $browser->createPage();
        $page->navigate($url)->waitForNavigation();
        $preview = $page->dom()->search('//*[@class="image-preview-card"]');

        $goods = collect();
        if (!$preview) {
            $lists = $page->dom()->querySelectorAll('.list');
            foreach ($lists as $list) {
                $goods->push($this->parseGoods($list));
            }
        } else {
            $page->evaluate("var categories = document.querySelectorAll('.collection__child__button:nth-child(2)');");
            $count_card = $page->evaluate('categories.length')->getReturnValue();
            for ($i = 0; $i < $count_card; $i++) {
                $goods->push($this->parseWithCards($page, $i));
            }
        }

        return $goods;
    }

    /**
     * @param  Page  $page
     * @param  int  $i
     *
     * @return Collection<int, ParserGoodsDTO>|void
     * @throws CommunicationException
     */
    public function parseWithCards(Page $page, int $i)
    {
        $page->evaluate("categories[$i].click();");
        sleep(1);
        $lists = $page->dom()->querySelectorAll('.list');
        /** @todo need fix this */
        foreach ($lists as $list) {
            return $this->parseGoods($list);
        }
    }

    /**
     * @param  Node  $list
     *
     * @return Collection<int, ParserGoodsDTO>
     */
    public function parseGoods(Node $list): Collection
    {
        $collect = collect();
        $category = trim($list->querySelector('.list__title')->getText());
        $goods = $list->querySelectorAll('.product-row');
        foreach ($goods as $good) {
            $image = $this->IfImageNotAvailable($good->querySelector('.product-row__image'));
            $name = $good->querySelector('.product-row__name span span')->getAttribute('text');
            $description = $good->querySelector('.product-row__info__description span');
            $description = $description ? $description->getAttribute('text') : '';
            $price = trim($good->querySelector('.product-row__price span')->getText());
            $status = $good->querySelector('button');
            $status_value = isset($status) ? GoodsStatus::AVAILABLE->value : GoodsStatus::UNAVAILABLE->value;
            $collect->push(new ParserGoodsDTO($name, $description, (int)$price, $status_value, $category, '', $image));
        }

        return $collect;
    }

    /**
     * @param  Node|null  $image
     *
     * @return string
     */
    public function IfImageNotAvailable(Node|null $image): string
    {
        if ($image) {
            return $image->getAttribute('src');
        }

        /** @var Images $imageNotAvailable */
        $imageNotAvailable = Images::query()->where('path', '=', 'images/image_not_available.png')->first();

        return route('images.show', ['hash' => $imageNotAvailable->hash]);
    }
}
