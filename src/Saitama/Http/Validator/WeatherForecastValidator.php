<?php

namespace Saitama\Http\Validator;

class WeatherForecastValidator extends AbstractValidator
{
    public function validate(array $responseArray): bool
    {
        if (!parent::validate($responseArray)) {
            false;
        }
        if (isset($responseArray['timezone']) && (!empty($responseArray['daily']))) {
            return true;
        }
        return false;
    }
}