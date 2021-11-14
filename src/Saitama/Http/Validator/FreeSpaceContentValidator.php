<?php

namespace Saitama\Http\Validator;

class FreeSpaceContentValidator extends AbstractValidator
{
    public function validate(array $responseArray): bool
    {
        if (!parent::validate($responseArray)) {
            false;
        }
        if (!empty($responseArray['results']['error'])) {
            return false;
        }
        if (empty($responseArray['results']['shop']) && (!is_array($responseArray['results']['shop']))) {
            return false;
        }
        return true;
    }
}