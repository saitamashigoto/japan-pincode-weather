<?php

namespace Saitama\Extractor\Response;

use Saitama\Http\Json\Response;
use Saitama\Model\Location\Address;

abstract class AddressExtractor
{
    public static function extract(Response $response): Address
    {
        $firstResource = self::getFirstResourceFormResponse($response);
        $address = $firstResource['address'];
        return new Address(
            $address['adminDistrict'] ?? null,
            $address['countryRegion'] ?? null,
            $address['formattedAddress'] ?? null,
            $address['locality'] ?? null,
            $address['postalCode'] ?? null
        );
    }

    private static function getFirstResourceFormResponse(Response $response): array
    {
        $content = $response->getContent();
        $firstResource = reset($content['resourceSets'][0]['resources']);
        return $firstResource;
    }
}