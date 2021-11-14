<?php

namespace Saitama\Model\Location;

class Address
{
    private  $adminDistrict;

    private $countryRegion;

    private $formattedAddress;
    
    private $locality;

    private $postalCode;
    
    public function __construct(
        string $adminDistrict = null,
        string $countryRegion = null,
        string $formattedAddress = null,
        string $locality = null,
        string $postalCode = null
    ) {
        if (!empty($postalCode) && strpos($formattedAddress, $postalCode) !== false) {
            $formattedAddress = str_replace($postalCode, '', $formattedAddress);
            $formattedAddress = trim($formattedAddress);   
        }
        $this->adminDistrict = $adminDistrict;
        $this->countryRegion = $countryRegion;
        $this->formattedAddress = $formattedAddress;
        $this->locality = $locality;
        $this->postalCode = $postalCode;
    }

    public function getAdminDistrict()
    {
        return $this->adminDistrict;
    }

    public function getCountryRegion()
    {
        return $this->countryRegion;
    }

    public function getFormattedAddress()
    {
        return $this->formattedAddress;
    }

    public function getLocality()
    {
        return $this->locality;
    }

    public function getPostalCode()
    {
        return $this->postalCode;
    }

    public function setAdminDistrict($adminDistrict)
    {
        $this->adminDistrict = $adminDistrict;
    }

    public function setCountryRegion($countryRegion)
    {
        $this->countryRegion = $countryRegion;
    }
    
    public function setFormattedAddress($formattedAddress)
    {
        $this->formattedAddress = $formattedAddress;
    }
    
    public function setLocality($locality)
    {
        $this->locality = $locality;
    }
    
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postCode;
    }

    public function __toString()
    {
        return $this->getFormattedAddress();
    }
}