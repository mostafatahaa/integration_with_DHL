<?php

namespace App\RequestBuilders\DHL;

class DhlInternationalShippingtBuilder
{
    private $data = [];

    /**
     * Identifies the date and time the package is ready for pickup
     * @param $setPlannedShippingDateAndTime The date should not be a past date or a date more than 10 days in the future
     * If you want a pickup today, and it's currently before 11:00 AM, you can schedule the shipping time to start at 11:00 AM.
     * Your closeTime should be at least 2 hours after the pickup time.
     * For example, if the shipping time is 2024-08-07T11:00:00, the closeTime should be no earlier than 2024-08-07T13:00:00.
     * @return $this
     */
    public function setPlannedShippingDateAndTime($plannedPickupDateAndTime)
    {
        $this->data['plannedShippingDateAndTime'] = $plannedPickupDateAndTime;
        return $this;
    }

    /**
     * @param $productCode string:max:6, get the product code from shipping rates request
     * @return $this
     */
    public function setProductCode($productCode)
    {
        $this->data['productCode'] = $productCode;
        return $this;
    }

    /**
     * Sets the pickup details for the shipment.
     *
     * @param bool $isRequested Indicates if a pickup is required.
     *
     * @return $this
     */
    public function setPickup($isRequested)
    {
        $this->data['pickup']['isRequested'] = $isRequested;

        return $this;
    }

    public function setPickupCloseTime($closeTime)
    {
        $this->data['pickup']['closeTime'] = $closeTime;

        return $this;
    }

    public function setPickupPostalAddress($pickupPostalCode, $address, $cityName, $countryCode)
    {
        $this->data['pickup']['pickupDetails']['postalAddress'] = [
            'postalCode' => $pickupPostalCode,
            'addressLine1' => $address,
            'cityName' => $cityName,
            'countryCode' => $countryCode,
        ];

        return $this;
    }

    public function setPickupContactInfo($phone, $companyName, $fullName)
    {
        $this->data['pickup']['pickupDetails']['contactInformation'] = [
            'phone' => $phone,
            'companyName' => $companyName,
            'fullName' => $fullName,
        ];

        return $this;
    }

    /**
     * Sets output image properties for the shipment.
     *
     * @param string $encodingFormat The desired encoding format for the output documents.
     *Valid options: pdf, zpl, lp2, epl. Note that invoice and shipment receipt will always be PDF.
     * @param bool $hideAccountNumber Whether to hide account number on the waybillDoc.
     * @param bool $isRequested Whether to request the document or not. Valid for waybillDoc, invoice, shipment receipt, and QRcode.
     * @param string $typeCode The type of document for which to set properties. Valid options: label, waybillDoc, invoice, qr-code, shipmentReceipt.
     *
     * @return $this
     */
    public function setOutputImageProperties($hideAccountNumber = false, $encodingFormat = 'pdf', $isRequested = true)
    {
        $this->data['outputImageProperties']['encodingFormat'] = $encodingFormat;
        $this->data['outputImageProperties']['imageOptions'] = [
            [
                'invoiceType' => 'commercial',
                'isRequested' => $isRequested,
                'typeCode' => 'invoice',
            ],
            [
                'hideAccountNumber' => $hideAccountNumber,
                'isRequested' => $isRequested,
                'typeCode' => 'waybillDoc',
            ]
        ];
        return $this;
    }


    public function setShipperPostalDetails($postalCode, $cityName, $countryCode, $addressLine1)
    {
        $this->data['customerDetails']['shipperDetails']['postalAddress'] = [
            'postalCode' => $postalCode,
            'cityName' => $cityName,
            'countryCode' => $countryCode,
            'addressLine1' => $addressLine1,
        ];
        return $this;
    }

    public function setShipperContactInformationDetails($phone, $companyName, $fullName)
    {
        $this->data['customerDetails']['shipperDetails']['contactInformation'] = [
            'phone' => $phone,
            'companyName' => $companyName,
            'fullName' => $fullName,
        ];
        return $this;
    }

    public function setReceiverPostalDetails($postalCode, $cityName, $countryCode, $addressLine1)
    {
        $this->data['customerDetails']['receiverDetails']['postalAddress'] = [
            'postalCode' => $postalCode,
            'cityName' => $cityName,
            'countryCode' => $countryCode,
            'addressLine1' => $addressLine1,
        ];
        return $this;
    }

    public function setReceiverContactInformationDetails($phone, $companyName, $fullName, $email = null)
    {
        $this->data['customerDetails']['receiverDetails']['contactInformation'] = [
            'phone' => $phone,
            'companyName' => $companyName,
            'fullName' => $fullName,
            'email' => $email,
        ];
        return $this;
    }


    /**
     * Set whether the shipment is subject to customs duties.
     *
     * @param bool $boolVal True if dutiable, false if non-dutiable.
     * @return $this
     */
    public function setShipmentIsCustomsDeclarable($boolVal = true, $description)
    {
        $this->data['content']['isCustomsDeclarable'] = $boolVal;
        $this->data['content']['description'] = $description;
        return $this;
    }

    public function setShipmentCustomsDeclarableData($declaredValue = true, $declaredValueCurrency)
    {
        $this->data['content']['declaredValue'] = $declaredValue;
        $this->data['content']['declaredValueCurrency'] = $declaredValueCurrency;
        return $this;
    }

    public function setShipmentIncoterm()
    {
        $this->data['content']['incoterm'] = 'DAP';
        return $this;
    }

    public function setExportDeclarationInvoice($invoiceDate, $invoiceNumber)
    {
        $this->data['content']['exportDeclaration'] = [
            'invoice' => [
                'date' => $invoiceDate,
                'number' => $invoiceNumber,
            ],
        ];
        return $this;
    }

    /**
     * Add a line item to the export declaration.
     *
     * @param array $lineItemDetails
     * @return $this
     */
    public function setExportDeclarationLineItem(array $lineItemDetails)
    {
        $lineItemDetails['number'] = count($this->data['content']['exportDeclaration']['lineItems'] ?? []) + 1;

        $this->data['content']['exportDeclaration']['lineItems'][] = $lineItemDetails;

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

        $this->data['content']['unitOfMeasurement'] = $unitOfMeasurement;
        return $this;
    }

    public function setShipmentPackages($weight, $length, $width, $height)
    {
        $this->data['content']['packages'] = [
            [
                'weight' => $weight,
                'dimensions' => [
                    'length' => $length,
                    'width' => $width,
                    'height' => $height,
                ],
            ]
        ];
        return $this;
    }

    public function setAccounts($typeCode = 'shipper', $number = "")
    {
        $this->data['accounts'] = [
            [
                'number' => $number,
                'typeCode' => $typeCode,
            ]
        ];
        return $this;
    }


    public function getData()
    {
        return $this->data;
    }
}
