<?php

namespace Saitama\Http\Validator;

use Saitama\Exception\ValidatorNotFoundException;

class ValidatorPool
{
    private array $validatorsMap = [];

    public function __construct(array $validatorsMap = [])
    {
        if (empty($validatorsMap)) {
            $validatorsMap['postal_code'] = PostalCodeValidator::class; 
            $validatorsMap['point'] = PointValidator::class; 
            $validatorsMap['address'] = AddressValidator::class; 
            $validatorsMap['free_space_content'] = FreeSpaceContentValidator::class; 
            $validatorsMap['weather_forecast'] = WeatherForecastValidator::class; 
        }
        foreach ($validatorsMap as $type => $class) {
            $this->validatorsMap[$type] = new $class();
        }
    }
    
    public function get(string $type): AbstractValidator
    {
        if (empty($this->validatorsMap[$type])) {
            throw new ValidatorNotFoundException(sprintf('Invalid Validator type "%s" given', $type));
        }
        return $this->validatorsMap[$type];
    }
}