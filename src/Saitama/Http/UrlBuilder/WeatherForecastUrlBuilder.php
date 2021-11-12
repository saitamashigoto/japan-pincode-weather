<?php

namespace Saitama\Http\UrlBuilder;

class WeatherForecastUrlBuilder extends UrlBuilder
{
    const WEATHER_FORECASE_URL_TEMPLATE = '"https://api.openweathermap.org/data/2.5/onecall?" .
            "exclude=current,minutely,hourly&appid=f86ff2548680116dd9dbb5e81d941a85&lang=ja&units=metric&" .
            "lon=:long&lat=:lat"';
    
    public function build(string $urlTemplate = "", array $params = []): string
    {
        $url = empty($urlTemplate) ? self::WEATHER_FORECASE_URL_TEMPLATE : $urlTemplate;
        return parent::build($url, $params);
    }
}