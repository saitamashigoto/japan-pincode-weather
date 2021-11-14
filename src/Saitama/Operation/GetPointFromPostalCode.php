<?php

namespace Saitama\Operation;

use Saitama\Http\Validator\ValidatorBuilder;
use Saitama\Http\UrlBuilder\UrlBuilder;
use Saitama\Exception\InvalidPostalCodeException;
use Saitama\Exception\RequestFailedException;
use Saitama\Exception\InvalidContentException;
use Saitama\Http\CurlClient;
use Saitama\Http\ResponseBuilder;
use Saitama\Model\Location\Point;
use Saitama\Extractor\Response\PointExtractor;

abstract class GetPointFromPostalCode
{
    public function execute(string $postalCode): Point
    {
        $postalCodeValidator = ValidatorBuilder::get('postal_code');
        if (!$postalCodeValidator->validate(['postal_code' => $postalCode])) {
            throw new InvalidPostalCodeException(sprintf('Invalid postal code format "%s"', $postalCode));
        }
        
        $locationUrlBuilder = UrlBuilder::get('location');
        $locationUrl = $locationUrlBuilder->build('', [':postalCode' => $postalCode]);
        
        $curlResponse = CurlClient::makeRequest($locationUrl);
        $response = ResponseBuilder::build($curlResponse);

        if ($response->getIsError()) {
            throw new RequestFailedException(sprintf('Unable to fetch location: "%s"', $response->getErrorMessage()));
        }
        
        $pointValidator = ValidatorBuilder::get('point');
        $content = $response->getContent();
        if (!$pointValidator->validate($content)) {
            throw new InvalidContentException('Invalid data received from server');
        }
        $pointM = PointExtractor::extract($response);
        return $pointM;
    }
}