<?php

namespace Saitama\Extractor\Response;

use Saitama\Http\Json\Response;
use Saitama\Model\FreespaceContent\Shop;
use Saitama\Model\Collection;

abstract class ShopCollectionExtractor
{
    const MAX_RESULTS = 10;

    public static function extract(Response $response): Collection
    {
        $content = $response->getContent();
        $totalCount = \min(self::MAX_RESULTS, $content['results']['results_returned']);
        $shops = $content['results']['shop'];
        $slicedShops = array_slice($shops, 0, $totalCount);
        $shopsModelArr = [];
        foreach($slicedShops as $shop) {
            $shopsModelArr[] = new Shop(
                $shop['urls']['pc'],
                $shop['name']
            );
        }
        
        $shopsCollection = new Collection($shopsModelArr);
        return $shopsCollection;
    }
}