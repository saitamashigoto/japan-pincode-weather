<?php

namespace Saitama\Http\Validator;

class PostalCodeValidator extends AbstractValidator
{
    public function validate(array $responseArray): bool
    {
        if (!parent::validate($responseArray)) {
            false;
        }
        $postalCode = $responseArray['postal_code'];
        return 1 === preg_match('/^[0-9]{3}-[0-9]{4}$/', $postalCode);
    }
}