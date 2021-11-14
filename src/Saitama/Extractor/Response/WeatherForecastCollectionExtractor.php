<?php

namespace Saitama\Extractor\Response;

use Saitama\Http\Json\Response;
use Saitama\Http\UrlBuilder\UrlBuilder;
use Saitama\Model\WeatherForecast\WeatherForecast;
use Saitama\Model\Collection;

abstract class WeatherForecastCollectionExtractor
{
    const DATE_FORMAT = 'Y-m-d';
    const WEEKDAY_FORMAT = 'N';

    protected static $weekdaysMap = [
      1 => '月曜日',
      2 => '火曜日',
      3 => '水曜日',
      4 => '木曜日',
      5 => '金曜日',
      6 => '土曜日',
      7 => '日曜日',
    ];

    public static function extract(Response $response): Collection
    {
        $content = $response->getContent();
        
        \date_default_timezone_set($content['timezone']);
        $threeDaysForecast = array_chunk($content['daily'], 3)[0];
        
        $weatherIconUrlBuilder = UrlBuilder::get('weather_icon');
        $weatherForcasts = [];
        foreach ($threeDaysForecast as $forecast) {
            $date = date(self::DATE_FORMAT, $forecast['dt']);
            $weekday = date(self::WEEKDAY_FORMAT, $forecast['dt']);
            $weekdayJapaneseName = self::$weekdaysMap[$weekday];
            $weatherDesc = $forecast['weather'][0]['description'];
            $tempMin = $forecast['temp']['min'];
            $tempMax = $forecast['temp']['max'];
            $weatherIconUrl = $weatherIconUrlBuilder->build(
                "", 
                [':icon' => $forecast['weather'][0]['icon']]
            );
            $weatherForcasts[] = new WeatherForecast(
                $weatherDesc,
                $date,
                $weekdayJapaneseName,
                $tempMin,
                $tempMax,
                $weatherIconUrl
            );
        }
        $weatherForcastsCollection = new Collection($weatherForcasts);
        return $weatherForcastsCollection;
    }
}