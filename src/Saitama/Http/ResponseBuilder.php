<?php

namespace Saitama\Http;

abstract class ResponseBuilder
{
    public static function makeRequest(string $url): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $body = curl_exec($ch);
        if (curl_errno($ch)) {
            $errorMsg = curl_error($ch);
            $response = self::getCurlResponse(false, $errorMsg);
        } else {
            $response = self::getCurlResponse(true);
        }
        if (self::isJson($body)) {
            $response['data'] = json_decode($body, true);
        }
        curl_close($ch);
        return $response;
    }

    private static function isJson(string $responseString): bool
    {
        return is_string($responseString)
        && is_array(json_decode($responseString, true))
        && (json_last_error() == JSON_ERROR_NONE)
        ? true : false;
    }

    private static function getCurlResponse(bool $success = false, string $message = "", array $data = []): array
    {
        return [
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ];
    }
}