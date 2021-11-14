<?php require_once __DIR__ . '/src/Saitama/autoload.php';
ini_set('display_errors', 1);

use Saitama\Operation\GetPointFromPostalCode;
use Saitama\Operation\GetAddressFromPostalCode;
use Saitama\Operation\GetWeatherForecastCollectionFromPoint;
use Saitama\Operation\GetShopCollectionFromPoint;

$point = GetPointFromPostalCode::execute('039-2189');
$address = GetAddressFromPostalCode::execute('039-2189');
// $weatherForecastCollection = GetWeatherForecastCollectionFromPoint::execute($point);
$shopCollection = GetShopCollectionFromPoint::execute($point);
var_dump($shopCollection->getItems());