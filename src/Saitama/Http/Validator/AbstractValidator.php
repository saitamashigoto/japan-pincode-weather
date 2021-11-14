<?php

namespace Saitama\Http\Validator;

abstract class AbstractValidator
{
    public function validate(array $responseArray): bool
    {
        if (empty($responseArray)) {
            return false;
        }
        return true;
    }
}