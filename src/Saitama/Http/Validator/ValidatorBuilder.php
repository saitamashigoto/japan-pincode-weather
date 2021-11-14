<?php

namespace Saitama\Http\Validator;

abstract class ValidatorBuilder
{
    private static ValidatorPool $validatorPool;
    
    public static function get(string $type): AbstractValidator
    {
        if (empty(self::$validatorPool)) {
            self::$validatorPool = new ValidatorPool();
        }
        return self::$validatorPool->get($type);
    }
}