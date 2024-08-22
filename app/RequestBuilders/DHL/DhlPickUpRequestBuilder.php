<?php

namespace App\RequestBuilders\DHL;

class DhlPickUpRequestBuilder
{
    private $data = [];

    /**
     * Identifies the date and time the package is ready for pickup
     * @param $plannedPickupDateAndTime The date should not be a past date or a date more than 10 days in the future
     * If you want a pickup today, and it's currently before 11:00 AM, you can schedule the pickup time to start at 11:00 AM.
     * Your closeTime should be at least 2 hours after the pickup time.
     * For example, if the pickup time is 2024-08-07T11:00:00, the closeTime should be no earlier than 2024-08-07T13:00:00.
     * @return $this
     */
    public function setPlannedPickupDateAndTime($plannedPickupDateAndTime)
    {
        $this->data['plannedPickupDateAndTime'] = $plannedPickupDateAndTime;
        return $this;
    }

    /**
     * Sets the closing time for the pickup request.
     *
     * This method defines the latest time by which the shipment should be ready for pickup.
     * The closing time must be at least 2 hours after the planned pickup time to ensure there is enough time for the courier to collect the shipment.
     *
     * @param string $closeTime The latest time in the format 'HH:mm', 18:00 for 6:00 PM.
     *
     * @return $this
     */
    public function setCloseTime($closeTime)
    {
        $this->data['closeTime'] = $closeTime;
        return $this;
    }

    /**
     * @param $location string:max:80, information on where the package should be picked up
     * @return $this
     */
    public function setLocation($location)
    {
        $this->data['location'] = $location;
        return $this;
    }

    /**
     * @param $locationType Enum value:["business","residence"]
     * @return $this
     */
    public function setLocationType($locationType)
    {
        $this->data['locationType'] = $locationType;
        return $this;
    }

    #TODO::NO need this method for now

    /**
     * @param $remark string, Additional notes, Default is null
     * @return $this
     */
    public function setRemark($remark = "")
    {
        $this->data['remark'] = $remark;
        return $this;
    }

    public function setShipperPostalDetails($postalCode, $cityName, $countryCode, $addressLine1, $addressLine2 = null, $addressLine3 = null, $countryName)
    {
        $this->data['customerDetails']['shipperDetails']['postalAddress'] = [
            'postalCode' => $postalCode,
            'cityName' => $cityName,
            'countryCode' => $countryCode,
            'addressLine1' => $addressLine1,
            'addressLine2' => $addressLine2,
            'addressLine3' => $addressLine3,
            'countyName' => $countryName,
        ];
        return $this;
    }

    public function setShipperContactInformationDetails($email, $phone, $companyName, $fullName)
    {
        $this->data['customerDetails']['shipperDetails']['contactInformation'] = [
            'email' => $email,
            'phone' => $phone,

            'companyName' => $companyName,
            'fullName' => $fullName,
        ];
        return $this;
    }

    public function setReceiverPostalDetails($postalCode, $cityName, $countryCode, $provinceCode, $addressLine1, $addressLine2 = null, $addressLine3 = null, $countryName)
    {
        $this->data['customerDetails']['receiverDetails']['postalAddress'] = [
            'postalCode' => $postalCode,
            'cityName' => $cityName,
            'countryCode' => $countryCode,
            'provinceCode' => $provinceCode,
            'addressLine1' => $addressLine1,
            'addressLine2' => $addressLine2,
            'addressLine3' => $addressLine3,
            'countyName' => $countryName,
        ];
        return $this;
    }

    public function setReceiverContactInformationDetails($email, $phone, $companyName, $fullName)
    {
        $this->data['customerDetails']['receiverDetails']['contactInformation'] = [
            'email' => $email,
            'phone' => $phone,

            'companyName' => $companyName,
            'fullName' => $fullName,
        ];
        return $this;
    }

    public function setBookingRequestPostalAddressDetails($postalCode, $cityName, $countryCode, $provinceCode, $addressLine1, $addressLine2 = null, $addressLine3 = null, $countryName)
    {
        $this->data['customerDetails']['bookingRequestorDetails']['postalAddress'] = [
            'postalCode' => $postalCode,
            'cityName' => $cityName,
            'countryCode' => $countryCode,
            'provinceCode' => $provinceCode,
            'addressLine1' => $addressLine1,
            'addressLine2' => $addressLine2,
            'addressLine3' => $addressLine3,
            'countyName' => $countryName,
        ];
        return $this;
    }

    public function setBookingRequestContactInformationDetails($email, $phone, $companyName, $fullName)
    {
        $this->data['customerDetails']['bookingRequestorDetails']['contactInformation'] = [
            'email' => $email,
            'phone' => $phone,

            'companyName' => $companyName,
            'fullName' => $fullName,
        ];
        return $this;
    }

    public function setPickUpRequestPostalAddressDetails($postalCode, $cityName, $countryCode, $provinceCode, $addressLine1, $addressLine2 = null, $addressLine3 = null, $countryName)
    {
        $this->data['customerDetails']['pickupDetails']['postalAddress'] = [
            'postalCode' => $postalCode,
            'cityName' => $cityName,
            'countryCode' => $countryCode,
            'provinceCode' => $provinceCode,
            'addressLine1' => $addressLine1,
            'addressLine2' => $addressLine2,
            'addressLine3' => $addressLine3,
            'countyName' => $countryName,
        ];
        return $this;
    }

    public function setPickUpRequestContactInformationDetails($email, $phone, $companyName, $fullName)
    {
        $this->data['customerDetails']['pickupDetails']['contactInformation'] = [
            'email' => $email,
            'phone' => $phone,

            'companyName' => $companyName,
            'fullName' => $fullName,
        ];
        return $this;
    }

    public function setShipmentProductCode($productCode, $localProductCode)
    {
        $this->data['shipmentDetails'][] = [
            'productCode' => $productCode,
            'localProductCode' => $productCode,
        ];
        return $this;
    }

    /**
     * Set whether the shipment is subject to customs duties.
     *
     * @param bool $boolVal True if dutiable, false if non-dutiable.
     * @return $this
     */
    public function setShipmentIsCustomsDeclarable($boolVal)
    {
        $this->data['shipmentDetails'][0]['isCustomsDeclarable'] = $boolVal;
        return $this;
    }

    /**
     * Set the declared value of the shipment for customs.
     *
     * @param float $val The value of the shipment.
     * @return $this
     */
    public function setShipmentDeclaredValue($val)
    {
        $this->data['shipmentDetails'][0]['declaredValue'] = $val;
        return $this;
    }

    /**
     * Set the currency code for the declared value.
     *
     * @param string $currency The 3-letter currency code.
     * @return $this
     */
    public function setShipmentDeclaredValueCurrency($currency)
    {
        $this->data['shipmentDetails'][0]['declaredValueCurrency'] = $currency;
        return $this;
    }


    /**
     * Set the unit of measurement for the shipment.
     *
     * @param string $unitOfMeasurement The unit of measurement, either "metric" or "imperial". Defaults to "metric".
     * @return $this
     */
    public function setShipmentUnitOfMeasurement($unitOfMeasurement = 'metric')
    {
        $validUnits = ['metric', 'imperial'];
        if (!in_array($unitOfMeasurement, $validUnits)) {
            $unitOfMeasurement = 'metric';
        }

        $this->data['shipmentDetails'][0]['unitOfMeasurement'] = $unitOfMeasurement;
        return $this;
    }

    public function setShipmentPackages($weight, $length, $width, $height)
    {
        $this->data['shipmentDetails'][0]['packages'][] = [
            'weight' => $weight,
            'dimensions' => [
                'length' => $length,
                'width' => $width,
                'height' => $height,
            ],
        ];
        return $this;
    }


    public function setShipmentAccountsDetails()
    {
        $this->data['shipmentDetails'][0]['accounts'] = $this->setAccounts()->getData()['accounts'];
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

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
}
