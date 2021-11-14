<?php

namespace Saitama\Http\UrlBuilder;

class FreeSpaceContentUrlBuilder extends AbstractUrlBuilder
{
    const FREE_SPACE_CONTENT_URL_TEMPLATE = "https://webservice.recruit.co.jp/hotpepper/gourmet/v1/?key=1f1c05b5ec757f8c".
        "&lat=:lat&lng=:long&format=json&" .
            "range=:range";
    
    public function build(string $urlTemplate = "", array $params = []): string
    {
        $url = empty($urlTemplate) ? self::FREE_SPACE_CONTENT_URL_TEMPLATE : $urlTemplate;
        return parent::build($url, $params);
    }
}