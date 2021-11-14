<?php

namespace Saitama\Http\UrlBuilder;

class LocationUrlBuilder extends AbstractUrlBuilder
{
    const LOCATION_URL_TEMPLATE = "http://dev.virtualearth.net/REST/v1/Locations?countryRegion=JP"
        ."&postalCode=:postalCode&key=AvvgpVVNrJGOAJhQZCOTCLhOFZaXoJ-jRQHMvcDt7yybzOajKP_HDy3lSZ4enKMh&strictMatch=1&culture=ja";
    
    public function build(string $urlTemplate = "", array $params = []): string
    {
        $url = empty($urlTemplate) ? self::LOCATION_URL_TEMPLATE : $urlTemplate;
        return parent::build($url, $params);
    }
}