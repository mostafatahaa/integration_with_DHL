<?php

namespace App\RequestBuilders\DHL;

class DhlRatingRequestBuilder
{
    private $data = [];

    public function setShipperDetails($cityName, $countryCode, $postalCode = "")
    {
        $this->data['customerDetails']['shipperDetails'] = [
            'postalCode' => $postalCode,
            'cityName' => $cityName,
            'countryCode' => $countryCode,
            'provinceCode' => $countryCode,
            'addressLine1' => $cityName
        ];
        return $this;
    }

    public function setReceiverDetails($cityName, $countryCode, $postalCode = "")
    {
        $this->data['customerDetails']['receiverDetails'] = [
            'postalCode' => $postalCode,
            'cityName' => $cityName,
            'addressLine1' => $cityName,
            'countryCode' => $countryCode
        ];
        return $this;
    }

    /**
     * Sets the account information for the shipment.
     *
     * This method sets the account details in the data array, including the account type and number.
     *
     * @param string $typeCode The type of account (e.g., 'shipper'). Defaults to 'shipper'.
     * @param string $number The account number will be user account number, and it should be stored in database.
     *
     * @return $this
     */
    public function setAccounts($typeCode = 'shipper', $number = "")
    {
        $this->data['accounts'] = [
            [
                'typeCode' => $typeCode,
                'number' => $number
            ]
        ];
        return $this;
    }

    public function setPlannedShippingDateAndTime($plannedShippingDateAndTime)
    {
        $adjustedPickupTime = $plannedShippingDateAndTime->addDays(4)->setTime(15, 00, 00);

        $this->data['plannedShippingDateAndTime'] = $adjustedPickupTime->format('Y-m-d\TH:i:s');

        return $this;
    }

    /**
     * Sets the unit of measurement for weight and dimensions.
     *
     * This method sets the unit of measurement used for weight and dimensions in the data array.
     * The default value is "metric". The possible values are:
     * - "metric" for kilograms and centimeters
     * - "imperial" for pounds and inches
     *
     * @param string $unitOfMeasurement The unit of measurement. Possible values are:
     *                                  - "metric": Uses kilograms and centimeters.
     *                                  - "imperial": Uses pounds and inches.
     *                                  Defaults to "metric".
     *
     * @return $this
     */
    public function setUnitOfMeasurement($unitOfMeasurement = 'metric')
    {
        $this->data['unitOfMeasurement'] = $unitOfMeasurement;
        return $this;
    }

    /**
     * Sets whether the shipment requires a customs declaration.
     *
     * This method sets the `isCustomsDeclarable` flag to indicate if the shipment or item needs to be declared to customs
     * for international shipping. If set to true, it means that the item must be declared to customs, which is typically required
     * for international shipments, regulated goods, high-value items, or items subject to tariffs. If set to false, the item
     * does not require customs declaration, which may be applicable for domestic shipments or non-regulated low-value items.
     *
     * @param bool $isCustomsDeclarable true for international shipment and false with domestic
     *
     * @return $this
     */
    public function setIsCustomsDeclarable($isCustomsDeclarable)
    {
        $this->data['isCustomsDeclarable'] = $isCustomsDeclarable;
        return $this;
    }


    /**
     * Sets whether to request all value-added services for each product.
     *
     * This is a legacy field and has been replaced by the newer field `getAdditionalInformation`.
     * Setting this to `true` will request all value-added services available for each product.
     *
     * @param bool $requestAllValueAddedServices Indicates if all value-added services should be requested.
     * @return $this
     */
    public function setRequestAllValueAddedServices($requestAllValueAddedServices)
    {
        $this->data['requestAllValueAddedServices'] = $requestAllValueAddedServices;
        return $this;
    }

    public function setReturnStandardProductsOnly($returnStandardProductsOnly)
    {
        $this->data['returnStandardProductsOnly'] = $returnStandardProductsOnly;
        return $this;
    }

    public function setNextBusinessDay($nextBusinessDay)
    {
        $this->data['nextBusinessDay'] = $nextBusinessDay;
        return $this;
    }

    /**
     * Sets the package information for the shipment.
     *
     * This method sets the package details in the data array, including weight and dimensions.
     * Note: Parameters with a default value of 1 (length, width, height) are used for rating results
     * and do not reflect the actual dimensions.
     *
     * @param float $weight The weight of the package in kilograms.
     * @param float $length The length of the package. Defaults to 1. Used for rating results.
     * @param float $width The width of the package. Defaults to 1. Used for rating results.
     * @param float $height The height of the package. Defaults to 1. Used for rating results.
     *
     * @return $this
     */
    public function setPackages($weight, $length = 1, $width = 1, $height = 1)
    {
        $this->data['packages'] = [
            [
                'weight' => $weight,
                'dimensions' => [
                    'length' => $length,
                    'width' => $width,
                    'height' => $height
                ]
            ]
        ];
        return $this;
    }


    public function getData()
    {
        return $this->data;
    }
}
