<?php

namespace Saitama\Http;

use Saitama\Http\Json\Response;

abstract class ResponseBuilder
{
    public static function build(array $responseArray): Response
    {
        $isError = !$responseArray['success'];
        $errorMessage = $responseArray['message'];
        $responseArray = $responseArray['content'];
        return new Response($isError, $errorMessage, $responseArray);
    }
}