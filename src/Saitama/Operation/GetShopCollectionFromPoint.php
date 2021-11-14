<?php

namespace Saitama\Operation;

use Saitama\Http\Validator\ValidatorBuilder;
use Saitama\Http\UrlBuilder\UrlBuilder;
use Saitama\Exception\RequestFailedException;
use Saitama\Exception\InvalidContentException;
use Saitama\Http\CurlClient;
use Saitama\Http\ResponseBuilder;
use Saitama\Model\Collection;
use Saitama\Model\Location\Point;
use Saitama\Extractor\Response\ShopCollectionExtractor;

abstract class GetShopCollectionFromPoint
{
    const DEFAULT_RANGE = 5;

    public function execute(Point $point): Collection
    {
        $freeSpaceContentUrlBuilder = UrlBuilder::get('free_space_content');
        $urlParms = [
            ':lat' => $point->getLatitude(),
            ':long' => $point->getLongitude(),
            ':range' => self::DEFAULT_RANGE,
        ];
        $freeSpaceContentUrl = $freeSpaceContentUrlBuilder->build('', $urlParms);
        
        $curlResponse = CurlClient::makeRequest($freeSpaceContentUrl);
        $response = ResponseBuilder::build($curlResponse);

        if ($response->getIsError()) {
            throw new RequestFailedException(sprintf('Unable to fetch free space content: "%s"', $response->getErrorMessage()));
        }
        
        $freeSpaceContentValidator = ValidatorBuilder::get('free_space_content');
        $content = $response->getContent();
        if (!$freeSpaceContentValidator->validate($content)) {
            throw new InvalidContentException('Invalid data received from server');
        }
        $freeSpaceContentCollection = ShopCollectionExtractor::extract($response);
        return $freeSpaceContentCollection;
    }
}