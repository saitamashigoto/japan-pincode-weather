<?php

namespace Saitama\Operation;

use Saitama\Http\Validator\ValidatorBuilder;
use Saitama\Http\UrlBuilder\UrlBuilder;
use Saitama\Exception\InvalidPostalCodeException;
use Saitama\Exception\RequestFailedException;
use Saitama\Exception\InvalidContentException;
use Saitama\Http\CurlClient;
use Saitama\Http\ResponseBuilder;
use Saitama\Model\Location\Address;
use Saitama\Extractor\Response\AddressExtractor;

abstract class GetAddressFromPostalCode
{
    public function execute(string $postalCode): Address
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
        
        $addressValidator = ValidatorBuilder::get('address');
        $content = $response->getContent();
        if (!$addressValidator->validate($content)) {
            throw new InvalidContentException('Invalid data received from server');
        }
        $addressM = AddressExtractor::extract($response);
        return $addressM;
    }
}