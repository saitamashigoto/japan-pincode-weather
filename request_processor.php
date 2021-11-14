<?php require_once __DIR__ . '/src/Saitama/autoload.php';

use Saitama\Operation\GetPointFromPostalCode;
use Saitama\Operation\GetAddressFromPostalCode;
use Saitama\Operation\GetWeatherForecastCollectionFromPoint;
use Saitama\Operation\GetShopCollectionFromPoint;
use Saitama\Exception\InvalidPostalCodeException;
use Saitama\Exception\RequestFailedException;
use Saitama\Exception\InvalidContentException;

try {
    $postalCode = $_POST['postalCode'] ?? "";
    $point = GetPointFromPostalCode::execute($postalCode);
    $address = GetAddressFromPostalCode::execute($postalCode);
    $weatherForecastCollection = GetWeatherForecastCollectionFromPoint::execute($point);
    $shopCollection = GetShopCollectionFromPoint::execute($point);
} catch (InvalidPostalCodeException | RequestFailedException | InvalidContentException $e) {
    $message = $e->getMessage();
} catch (Throwable $e) {
    $message = 'Internal server error.';
}

include __DIR__ . '/index.php';