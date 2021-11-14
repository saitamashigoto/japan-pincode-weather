<?php

namespace Saitama\Model\WeatherForecast;

class WeatherForecast
{
    private $description;

    private $date;
    
    private $weekday;
    
    private $tempMin;
    
    private $tempMax;

    private $iconUrl;
    
    public function __construct(
        string $description = null,
        string $date = null,
        string $weekday = null,
        string $tempMin = null,
        string $tempMax = null,
        string $iconUrl = null
    ) {
        $this->description = $description;
        $this->date = $date;
        $this->weekday = $weekday;
        $this->tempMin = $tempMin;
        $this->tempMax = $tempMax;
        $this->iconUrl = $iconUrl;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getWeekday()
    {
        return $this->weekday;
    }
    
    public function getTempMin()
    {
        return $this->tempMin;
    }
    
    public function getTempMax()
    {
        return $this->tempMax;
    }

    public function getIconUrl()
    {
        return $this->iconUrl;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setWeekday($weekday)
    {
        $this->weekday = $weekday;
    }

    public function setTempMin($tempMin)
    {
        $this->tempMin = $tempMin;
    }

    public function setTempMax($tempMax)
    {
        $this->tempMax = $tempMax;
    }

    public function setIconUrl($iconUrl)
    {
        $this->iconUrl = $iconUrl;
    }
}