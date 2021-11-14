<?php

namespace Saitama\Http\UrlBuilder;

use Saitama\Exception\UrlBuilderNotFoundException;

class UrlBuilderPool
{
    private $urlBuildersMap;

    public function __construct(array $urlBuildersMap = [])
    {
        if (empty($urlBuildersMap)) {
            $urlBuildersMap['weather_forecast'] = WeatherForecastUrlBuilder::class; 
            $urlBuildersMap['location'] = LocationUrlBuilder::class; 
            $urlBuildersMap['free_space_content'] = FreeSpaceContentUrlBuilder::class; 
            $urlBuildersMap['weather_icon'] = WeatherIconUrlBuilder::class; 
        }
        foreach ($urlBuildersMap as $type => $class) {
            $this->urlBuildersMap[$type] = new $class();
        }
    }
    
    public function get(string $type): AbstractUrlBuilder
    {
        if (empty($this->urlBuildersMap[$type])) {
            throw new UrlBuilderNotFoundException(sprintf('Invalid Url Builder type "%s" given', $type));
        }
        return $this->urlBuildersMap[$type];
    }
}