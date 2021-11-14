<?php

namespace Saitama\Extractor\Response;

use Saitama\Http\Json\Response;
use Saitama\Model\Location\Address;
use Saitama\Model\Location\Point;

abstract class PointExtractor
{
    public static function extract(Response $response): Point
    {
        $firstResource = self::getFirstResourceFormResponse($response);
        $coordinates = $firstResource['point']['coordinates'];
        return new Point($coordinates[0], $coordinates[1]);
    }

    private static function getFirstResourceFormResponse(Response $response): array
    {
        $content = $response->getContent();
        $firstResource = reset($content['resourceSets'][0]['resources']);
        return $firstResource;
    }
}