<?php

namespace Saitama\Http\Validator;

class AddressValidator extends LocationValidator
{
    public function validate(array $responseArray): bool
    {
        if (!parent::validate($responseArray)) {
            return false;
        }
        $firstResource = $this->getFirstResource($responseArray);
        if (empty($firstResource['address']['formattedAddress'])) {
            return false;
        }
        return true;
    }
}