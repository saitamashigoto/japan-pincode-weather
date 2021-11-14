<?php

namespace Saitama\Http\UrlBuilder;

class WeatherIconUrlBuilder extends AbstractUrlBuilder
{
    const WEATHER_ICON_URL_TEMPLATE = "http://openweathermap.org/img/wn/:icon@4x.png";
    
    public function build(string $urlTemplate = "", array $params = []): string
    {
        $url = empty($urlTemplate) ? self::WEATHER_ICON_URL_TEMPLATE : $urlTemplate;
        return parent::build($url, $params);
    }
}