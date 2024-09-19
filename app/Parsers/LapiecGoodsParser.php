<?php

namespace App\Parsers;

use App\DTOs\ParserGoodsDTO;
use App\Models\Enums\GoodsStatus;
use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @todo need fix this
 */
class LapiecGoodsParser implements Parser
{
    /**
     * @param  string  $url
     * @param  array  $options
     *
     * @return Collection
     * @phpstan-ignore-next-line
     */
    public function parse(string $url, array $options = []): Collection
    {
        $html = file_get_contents($url);
        /** @var @phpstan-ignore-next-line $crawler */
        $crawler = new Crawler($html);
        $links = $crawler->filter('#menu-golovne-menyu-la-pyecz > li > a')->each(function (Crawler $node) {
            $category = $node->text();
            /** @phpstan-ignore-next-line */
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
     * @param $link
     *
     * @return Collection
     * @phpstan-ignore-next-line
     */
    public function parseLinks($link): Collection
    {
        $category_link = file_get_contents($link->getUri());
        $crawler = new Crawler($category_link);
        $categories = $link->getNode()->textContent;

        $goods = $crawler->filter('.productThumbnail')->each(function (Crawler $node, $i) use ($categories) {
            $category[$i] = $categories;
            $name = $node->filter('.productTitle > a')->text();
            $description = $node->filter('.productDescription > p')->first()->text('');
            $price = $node->filter('.productPrice > span')->text('0');
            $status = $node->filter('.productOrder > .button')->count() ? GoodsStatus::AVAILABLE->value : GoodsStatus::UNAVAILABLE->value;
            $weight = $node->filter('.productSize-W > .weight > em')->text('');
            $data = json_encode(['weight' => $weight]);
            $image = $node->filter('.image-hover > img')->attr('data-src');

            return new ParserGoodsDTO($name, $description, (int)$price, $status, $category[$i], $data, $image);
        });

        return collect($goods);
    }
}
