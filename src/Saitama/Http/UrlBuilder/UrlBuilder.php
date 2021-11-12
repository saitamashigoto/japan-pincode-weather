<?php

namespace Saitama\Http\UrlBuilder;

abstract class UrlBuilder
{
    public function build(string $urlTemplate = "", array $params = []): string
    {
        return str_replace(array_keys($params), array_values($params), $urlTemplate);
    }
}