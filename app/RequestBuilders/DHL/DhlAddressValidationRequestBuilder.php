<?php

namespace App\RequestBuilders\DHL;

use InvalidArgumentException;

class DhlAddressValidationRequestBuilder
{
    private $data = [];


    /**
     * Set the type of address validation request.
     *
     * @param string $type The type of validation request. Can be either 'pickup' or 'delivery'.
     * @return $this
     * @throws InvalidArgumentException If the provided type is not 'pickup' or 'delivery'.
     */
    public function setType($type)
    {
        if (!in_array($type, ['pickup', 'delivery'])) {
            throw new InvalidArgumentException("Invalid type provided. Allowed values are 'pickup' or 'delivery'.");
        }
        $this->data['type'] = $type;
        return $this;
    }

    public function setCountryCode($countryCode)
    {
        $this->data['countryCode'] = $countryCode;
        return $this;
    }

    public function setPostalCode($postalCode = null)
    {
        $this->data['postalCode'] = $postalCode;
        return $this;
    }

    public function setCityName($cityName = null)
    {
        $this->data['cityName'] = $cityName;
        return $this;
    }

    public function setCountyName($countyName = null)
    {
        $this->data['countyName'] = $countyName;
        return $this;
    }

    public function setStrictValidation($strictValidation)
    {
        $this->data['strictValidation'] = $strictValidation;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }
}

