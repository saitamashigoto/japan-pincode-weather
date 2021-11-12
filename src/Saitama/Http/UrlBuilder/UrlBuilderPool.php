<?php

namespace Saitama\Http\UrlBuilder;

use Saitama\Exception\UrlBuilderNotFoundException;

class UrlBuilderPool
{
    private $urlBuildersMap;

    public function __construct(array $urlBuildersMap = [])
    {
        foreach ($urlBuildersMap as $type => $class) {
            $this->urlBuildersMap[$type] = new $class();
        }
    }
    
    public function get(string $type): UrlBuilder
    {
        if (empty($this->urlBuildersMap[$type])) {
            throw new UrlBuilderNotFoundException(sprintf('Invalid Url Builder type "%s" given', $type));
        }
        return $this->urlBuildersMap[$type];
    }
}