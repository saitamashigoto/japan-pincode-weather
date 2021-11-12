<?php require_once __DIR__ . '/src/Saitama/autoload.php';
ini_set('display_errors', 1);
use Saitama\CurlClient;

$url = 'http://dev.virtualearth.net/REST/v1/Locations?countryRegion=JP&postalCode=0392189&key=AvvgpVVNrJGOAJhQZCOTCLhOFZaXoJ-jRQHMvcDt7yybzOajKP_HDy3lSZ4enKMh&strictMatch=1';
var_dump(CurlClient::makeRequest($url));