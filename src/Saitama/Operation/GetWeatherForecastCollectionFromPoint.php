<?php

namespace Saitama\Operation;

use Saitama\Http\Validator\ValidatorBuilder;
use Saitama\Http\UrlBuilder\UrlBuilder;
use Saitama\Exception\InvalidPostalCodeException;
use Saitama\Exception\RequestFailedException;
use Saitama\Exception\InvalidContentException;
use Saitama\Http\CurlClient;
use Saitama\Http\ResponseBuilder;
use Saitama\Model\Collection;
use Saitama\Model\Location\Point;
use Saitama\Extractor\Response\WeatherForecastCollectionExtractor;

abstract class GetWeatherForecastCollectionFromPoint
{
    public function execute(Point $point): Collection
    {
        $weatherForecastUrlBuilder = UrlBuilder::get('weather_forecast');
        $urlParms = [
            ':lat' => $point->getLatitude(),
            ':long' => $point->getLongitude(),
        ];
        $weatherForecastUrl = $weatherForecastUrlBuilder->build('', $urlParms);
        
        $curlResponse = CurlClient::makeRequest($weatherForecastUrl);
        $response = ResponseBuilder::build($curlResponse);

        if ($response->getIsError()) {
            throw new RequestFailedException(sprintf('Unable to fetch weather forecast: "%s"', $response->getErrorMessage()));
        }
        
        $weatherForecastValidator = ValidatorBuilder::get('weather_forecast');
        $content = $response->getContent();
        if (!$weatherForecastValidator->validate($content)) {
            throw new InvalidContentException('Invalid data received from server');
        }
        $weatherForecastCollection = WeatherForecastCollectionExtractor::extract($response);
        return $weatherForecastCollection;
    }
}