<?php

namespace App\Parsers;

use App\DTOs\ParserGoodsDTO;
use App\Models\Enums\GoodsStatus;
use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Link;

/**
 * @todo need fix this
 */
class ProntoPizzaGoodsParser implements Parser
{
    /** @var array<string> */
    private array $category = ['Салати', 'Конструктор', 'Акції'];

    /**
     * @param  string  $url
     * @param  array<string, mixed>  $options
     *
     * @return Collection<int, ParserGoodsDTO>
     */
    public function parse(string $url, array $options = []): Collection
    {
        $html = file_get_contents($url);
        $crawler = new Crawler($html);
        $links = $crawler->filter('.main__menu > li > a')->each(function (Crawler $node) {
            $category = $node->text();
            if (!in_array($category, $this->category)) {
                return $node->link();
            }

            return null;
        });
        $links = array_filter($links, function ($link) {
            return !is_null($link);
        });
        $goods = collect();
        foreach ($links as $link) {
            $goods->push($this->parseLinks($link));
        }

        return $goods;
    }

    /**
     * @param  Link  $link
     *
     * @return Collection<int, ParserGoodsDTO>
     */
    public function parseLinks(Link $link): Collection
    {
        $category_link = file_get_contents($link->getUri());
        $crawler = new Crawler($category_link);
        $categories = $link->getNode()->textContent;

        $goods = $crawler->filter('.product')->each(function (Crawler $node, $i) use ($categories) {
            $category[$i] = $categories;
            $name = $node->filter('.product_title > a')->text();
            $description = $node->filter('.product_desc')->text('');
            $price = $node->filter('.product_price > .price')->text('0');
            $status = $node->filter('.product_controls button')->count() ? GoodsStatus::AVAILABLE->value : GoodsStatus::UNAVAILABLE->value;
            $weight = $node->filter('.product_size')->text('');
            $data = json_encode(['weight' => $weight]);
            $image = $node->filter('.product_image > img')->attr('data-i-src');

            return new ParserGoodsDTO($name, $description, (int)$price, $status, $category[$i], $data, $image);
        });

        return collect($goods);
    }
}
