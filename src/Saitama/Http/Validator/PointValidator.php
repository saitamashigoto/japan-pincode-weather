<?php

namespace Saitama\Http\Validator;

class PointValidator extends LocationValidator
{
    public function validate(array $responseArray): bool
    {
        if (!parent::validate($responseArray)) {
            return false;
        }
        $firstResource = $this->getFirstResource($responseArray);
        if (empty($firstResource['point']['coordinates'])
        || false === is_array($firstResource['point']['coordinates'])
        || count($firstResource['point']['coordinates']) < 2 ) {
            return false;
        }
        return true;
    }
}