<?php

namespace Saitama\Http\Validator;

abstract class LocationValidator extends AbstractValidator
{
    const HTTP_OK = 200;

    public function validate(array $responseArray): bool
    {
        if (!parent::validate($responseArray)) {
            false;
        }
        if (isset($responseArray['statusCode']) && self::HTTP_OK != $responseArray['statusCode']) {
            return false;
        }
        if (false === isset($responseArray['resourceSets'][0]['estimatedTotal']) ||
            $responseArray['resourceSets'][0]['estimatedTotal'] < 1) {
            return false;
        }
        return true;
    }

    protected function getFirstResource(array $responseArray): array
    {
        $firstResource = reset($responseArray['resourceSets'][0]['resources']);
        return $firstResource;
    }
}