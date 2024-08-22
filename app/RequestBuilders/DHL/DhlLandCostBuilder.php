<?php

namespace App\RequestBuilders\DHL;

class DhlLandCostBuilder
{
    private $data = [];


    /**
     * Sets account details for the shipment.
     *
     * @param string $typeCode Type of account ('shipper').
     * @param string $number Account number.
     * @return $this
     */
    public function setAccounts($typeCode, $number)
    {
        $this->data['accounts'] = [
            [
                'typeCode' => $typeCode,
                'number' => $number,
            ]
        ];
        return $this;
    }

    /**
     * Sets customs and insurance details.
     *
     * @param bool $isCustomsDeclarable Whether customs declaration is required.
     * @param bool $isDTPRequested Whether delivery duty paid is requested.
     * @param bool $isInsuranceRequested Whether insurance is requested.
     * @return $this
     */
    public function setCustomsAndInsuranceDetails($isCustomsDeclarable, $isDTPRequested, $isInsuranceRequested)
    {
        $this->data['isCustomsDeclarable'] = $isCustomsDeclarable;
        $this->data['isDTPRequested'] = $isDTPRequested;
        $this->data['isInsuranceRequested'] = $isInsuranceRequested;
        return $this;
    }

    /**
     * Sets product code for the shipment.
     *
     * @param string $productCode
     * @return $this
     */
    public function setProductCode($productCode)
    {
        $this->data['productCode'] = $productCode;
        return $this;
    }

    /**
     * Sets local product code for the shipment.
     *
     * @param string $localProductCode
     * @return $this
     */
    public function setLocalProductCode($localProductCode)
    {
        $this->data['localProductCode'] = $localProductCode;
        return $this;
    }

    /**
     * Sets unit of measurement for the shipment.
     *
     * @param string $unitOfMeasurement
     * @return $this
     */
    public function setUnitOfMeasurement($unitOfMeasurement)
    {
        $this->data['unitOfMeasurement'] = $unitOfMeasurement;
        return $this;
    }

    /**
     * Sets currency code for the shipment.
     *
     * @param string $currencyCode
     * @return $this
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->data['currencyCode'] = $currencyCode;
        return $this;
    }

    /**
     * Sets customs declaration and other related details.
     *
     * @param bool $isCustomsDeclarable
     * @param bool $isDTPRequested
     * @param bool $isInsuranceRequested
     * @return $this
     */
    public function setShipperDetails($postalCode, $cityName, $countryCode)
    {
        $this->data['shipperDetails'] = [
            'postalCode' => $postalCode,
            'cityName' => $cityName,
            'countryCode' => $countryCode,
        ];
        return $this;
    }

    public function setReceiverDetails($postalCode, $cityName, $countryCode)
    {
        $this->data['receiverDetails'] = [
            'postalCode' => $postalCode,
            'cityName' => $cityName,
            'countryCode' => $countryCode,
        ];
        return $this;
    }

    /**
     * Sets the cost breakdown option.
     *
     * @param bool $getCostBreakdown
     * @return $this
     */
    public function setGetCostBreakdown($getCostBreakdown)
    {
        $this->data['getCostBreakdown'] = $getCostBreakdown;
        return $this;
    }

    /**
     * Sets shipment charges.
     *
     * @param array $charges
     * @return $this
     */
    public function setCharges(array $charges)
    {
        $this->data['charges'] = $charges;
        return $this;
    }

    /**
     * Sets shipment purpose.
     *
     * @param string $shipmentPurpose
     * @return $this
     */
    public function setShipmentPurpose($shipmentPurpose)
    {
        $this->data['shipmentPurpose'] = $shipmentPurpose;
        return $this;
    }

    /**
     * Sets transportation mode.
     *
     * @param string $transportationMode
     * @return $this
     */
    public function setTransportationMode($transportationMode)
    {
        $this->data['transportationMode'] = $transportationMode;
        return $this;
    }

    /**
     * Sets the merchant selected carrier name.
     *
     * @param string $merchantSelectedCarrierName
     * @return $this
     */
    public function setMerchantSelectedCarrierName($merchantSelectedCarrierName)
    {
        $this->data['merchantSelectedCarrierName'] = $merchantSelectedCarrierName;
        return $this;
    }

    /**
     * Sets package details.
     *
     * @param array $packages
     * @return $this
     */
    public function setPackageDetails($weight, $length, $width, $height)
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

    /**
     * Sets item details.
     *
     * @param array $items
     * @return $this
     */
    public function setItems(array $items)
    {
        $this->data['items'] = $items;
        return $this;
    }

    /**
     * Sets tariff formula request.
     *
     * @param bool $getTariffFormula
     * @return $this
     */
    public function setGetTariffFormula($getTariffFormula)
    {
        $this->data['getTariffFormula'] = $getTariffFormula;
        return $this;
    }

    /**
     * Sets quotation ID request.
     *
     * @param bool $getQuotationID
     * @return $this
     */
    public function setGetQuotationID($getQuotationID)
    {
        $this->data['getQuotationID'] = $getQuotationID;
        return $this;
    }

    /**
     * Returns the data array.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
