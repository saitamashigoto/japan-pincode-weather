<?php

namespace Saitama\Http\UrlBuilder;

abstract class UrlBuilder
{
    private static UrlBuilderPool $urlBuilderPool;
    
    public static function get(string $type): AbstractUrlBuilder
    {
        if (empty(self::$urlBuilderPool)) {
            self::$urlBuilderPool = new UrlBuilderPool();
        }
        return self::$urlBuilderPool->get($type);
    }
}