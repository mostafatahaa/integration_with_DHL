<?php

namespace App\Http\Controllers;

use App\RequestBuilders\DHL\DhlAddressValidationRequestBuilder;
use App\RequestBuilders\DHL\DhlDomesticShippingtBuilder;
use App\RequestBuilders\DHL\DhlInternationalShippingtBuilder;
use App\RequestBuilders\DHL\DhlLandCostBuilder;
use App\RequestBuilders\DHL\DhlPickUpRequestBuilder;
use App\RequestBuilders\DHL\DhlRatingRequestBuilder;
use App\RequestBuilders\DHL\DhlTrakingRequestBuilder;
use App\Services\DhlService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class DHLController extends Controller
{
    protected $dhlService;

    public function __construct(DHLService $dhlService)
    {
        $this->dhlService = $dhlService;
    }

    public function dhlGetRating()
    {
        $rateRequestBuilder = new DhlRatingRequestBuilder();
        $data = $rateRequestBuilder
            ->setShipperDetails('Makkah', 'SA')
            ->setReceiverDetails('Abha', 'SA')
            ->setPlannedShippingDateAndTime(Carbon::now('Asia/Riyadh'))
            ->setIsCustomsDeclarable(true)
            ->setPackages(50)
            ->setUnitOfMeasurement()
            ->setAccounts()
            ->setRequestAllValueAddedServices(false)
            ->setReturnStandardProductsOnly(false)
            ->setNextBusinessDay(false)
            ->getData();

        $response = $this->dhlService->getRates($data);
        return $response;

    }

    public function dhlCreatePickUpRequest()
    {
        // Initialize the pickup request builder
        $pickUpRequestBuilder = new DhlPickupRequestBuilder();

        // Set pickup request details using the request data
        $pickUpRequestBuilder
            ->setPlannedPickupDateAndTime('2024-08-20T14:00:31')
            ->setCloseTime('16:00')
            ->setLocation('reception')
            ->setLocationType('residence')
            ->setShipperPostalDetails(
                '14800',
                'Dubai',
                'AE',
                'address1',
                'address2',
                'address3',
                'Dubai'
            )
            ->setShipperContactInformationDetails(
                'that@before.de',
                '+1123456789',
                'Company Name',
                'Mostafa Taha Gabr'
            )
            ->setReceiverPostalDetails(
                '14800',
                'Prague',
                'CZ',
                'CZ',
                'V Parku 2308/10',
                'address2',
                'address3',
                'Central Bohemia'

            )
            ->setReceiverContactInformationDetails(
                'test@emailcom',
                '+155454811',
                'Company Name',
                'Mostafa Taha Gabr',
            )
            ->setBookingRequestPostalAddressDetails(
                '14800',
                'Prague',
                'CZ',
                'CZ',
                'V Parku 2308/10',
                'address2',
                'addres3',
                'Central Bohemia'
            )
            ->setBookingRequestContactInformationDetails(
                'test@emailcom',
                '+155454811',
                'Company Name',
                'Mostafa Taha Gabr',
            )
            ->setPickUpRequestPostalAddressDetails(
                '14800',
                'Prague',
                'CZ',
                'CZ',
                'V Parku 2308/10',
                'address2',
                'address3',
                'Central Bohemia'
            )
            ->setPickUpRequestContactInformationDetails(
                'test@emailcom',
                '+155454811',
                'Company Name',
                'Mostafa Taha Gabr',
            )
            ->setShipmentProductCode('D', 'D')
            ->setShipmentIsCustomsDeclarable(true) // if shipping is international
            ->setShipmentDeclaredValue(200) // shipment price - required if setShipmentIsCustomsDeclarable(true)
            ->setShipmentDeclaredValueCurrency('USD') // - required if setShipmentIsCustomsDeclarable(true)
            ->setShipmentUnitOfMeasurement()
            ->setShipmentPackages(
                15,
                22,
                22,
                55
            )
            ->setShipmentAccountsDetails();

        $requestData = $pickUpRequestBuilder->getData();

        $response = $this->dhlService->createPickUpRequest($requestData);

        return $response;
    }

    public function dhlCreateDomesticShipping()
    {
        $createDomesticShipping = new DhlDomesticShippingtBuilder();

        $createDomesticShipping->setPlannedShippingDateAndTime('2024-08-15T10:12:06 GMT+03:00');
        $createDomesticShipping->setPickup(true);
        $createDomesticShipping->setExportDeclarationInvoice('2024-08-07', 'INV12345');

        $createDomesticShipping->setShipmentCustomsDeclarableData(200, 'USD');
        $createDomesticShipping->setOutputImageProperties(false, 'pdf', false, 'waybillDoc');

        $createDomesticShipping->setExportDeclarationLineItem([
            'priceCurrency' => 'USD',
            'quantity' => [
                'unitOfMeasurement' => 'BOX',
                'value' => 1,
            ],
            'price' => 100.00,
            'description' => 'Sample Item',
            'weight' => [
                'netValue' => 1.0,
                'grossValue' => 1.2,
            ],
            'exportReasonType' => 'gift',
            'manufacturerCountry' => 'US'
        ]);

        $createDomesticShipping->setAccounts();
        $createDomesticShipping->setProductCode('N');
        $createDomesticShipping->setShipperPostalDetails(
            '',
            'Riyadh',
            'SA',
            'Riyadh Saudi Arabia',
            'Riyadh Saudi Arabia'
        );

        $createDomesticShipping->setShipperContactInformationDetails(
            '+1234567890',
            'Shipper Company',
            'Shipper Name'
        );

        $createDomesticShipping->setReceiverPostalDetails(
            '',
            'Makkah',
            'SA',
            'Mecca Saudi Arabia',
            'Mecca Saudi Arabia'
        );

        $createDomesticShipping->setReceiverContactInformationDetails(
            '1234567890',
            'Receiver Company',
            'Receiver Name'
        );

        $createDomesticShipping
            ->setShipmentIsCustomsDeclarable(false)
            ->setShipmentUnitOfMeasurement('metric')
            ->setPackageDescription('Cosmetics: Skincare')
            ->setShipmentPackages(15, 1.097, 18, 13);


        $requestData = $createDomesticShipping->getData();

        $response = $this->dhlService->createDomesticShipping($requestData);

        return $response;
    }


    public function dhlAddressValidation()
    {
        $addressValidation = new DhlAddressValidationRequestBuilder();

        $queryData = $addressValidation
            ->setType('pickup') // Set the type as 'pickup' or 'delivery'
            ->setCountryCode('SA') // Set the country code as 'CZ'
            ->setPostalCode('52802') // Set the postal code as '14800'
            ->setCityName('Aba Alworood') // Set the city name as 'Prague'
            ->setCountyName('Saudi Arabia') // Set the county name as 'praha'
            ->setStrictValidation('false') // Enable strict validation
            ->getData(); // Get the query data array

        $requestData = $addressValidation->getData($queryData);

        $response = $this->dhlService->validateAddress($requestData);

        return $response;

    }

    public function createInternationalShipment()
    {
        // Initialize the builder
        $shippingBuilder = new DhlInternationalShippingtBuilder();

        // Build the shipping request
        $requestData = $shippingBuilder
            ->setPlannedShippingDateAndTime('2024-08-15T14:43:06 GMT+03:00') #TODO:: error here
            ->setPickup(true)
            ->setPickupCloseTime('18:00')
            ->setPickupPostalAddress('14800', 'Makkah', 'Makkah', 'SA')
            ->setPickupContactInfo('12345', 'New York', 'Mostafa Taha')
            ->setOutputImageProperties(false, 'pdf', true)
            ->setShipperPostalDetails('12345', 'New York', 'US', '123 Main St')
            ->setShipperContactInformationDetails('1234567890', 'Shipper Company', 'John Doe')
            ->setReceiverPostalDetails('54321', 'Cairo', 'EG', '456 Another St', 'Apartment 5')
            ->setReceiverContactInformationDetails('0987654321', 'Receiver Company', 'Jane Smith', 'jane@example.com')
            ->setShipmentIsCustomsDeclarable(true, 'Gift')
            ->setShipmentIncoterm()
            ->setExportDeclarationInvoice('2024-08-07', 'INV12345')
            ->setExportDeclarationLineItem([
                'priceCurrency' => 'USD',
                'quantity' => [
                    'unitOfMeasurement' => 'BOX',
                    'value' => 1,
                ],
                'price' => 100.00,
                'description' => 'Sample Item',
                'weight' => [
                    'netValue' => 1.0,
                    'grossValue' => 1.2,
                ],
                'exportReasonType' => 'gift',
                'manufacturerCountry' => 'US'
            ])
            ->setShipmentUnitOfMeasurement('metric')
            ->setShipmentPackages(5.0, 10.0, 15.0, 20.0)
            ->setAccounts()
            ->setProductCode('P')
            ->setShipmentCustomsDeclarableData(55, 'USD')
            ->getData();

        // Now you can use the requestData to send a request to DHL
        $response = $this->dhlService->createInternationalShipping($requestData);


        return $response;

    }

    public function dhlTrackingStatus()
    {
        $addressValidation = new DhlTrakingRequestBuilder();

        $queryData = $addressValidation
            ->setLanguage('ara')
            ->setTrackingNumber('')
            ->getData();

        $response = $this->dhlService->shipmentTracking($queryData);

        return $response;
    }

    public function dhlGetLandCost()
    {
        $shippingBuilder = new DhlLandCostBuilder();

        $queryData = $shippingBuilder
            ->setShipperDetails('12211', 'Riyadh', 'SA')
            ->setReceiverDetails('24211', 'Makkah', 'SA')
            ->setAccounts('shipper', '')
            ->setProductCode('N')
            ->setLocalProductCode('N')
            ->setUnitOfMeasurement('metric')
            ->setCurrencyCode('SAR')
            ->setCustomsAndInsuranceDetails(false, false, false)
            ->setGetCostBreakdown(true)
            ->setShipmentPurpose('personal')
            ->setMerchantSelectedCarrierName('DHL')
            ->setPackageDetails(50, 25, 35, 15)
            ->setItems([
                [
                    'number' => 1,
                    'name' => 'KNITWEAR COTTON',
                    'description' => 'KNITWEAR 100% COTTON REDUCTION PRICE FALL COLLECTION',
                    'manufacturerCountry' => 'SA',
                    'quantity' => 1,
                    'quantityType' => 'prt',
                    'unitPrice' => 0,
                    'unitPriceCurrencyCode' => 'SAR',

                    'weightUnitOfMeasurement' => 'metric',

                    'estimatedTariffRateType' => 'derived_rate'
                ]
            ])
            ->setGetTariffFormula(true)
            ->setGetQuotationID(false)
            ->getData();


        $response = $this->dhlService->getPriceDetails($queryData);

        return $response;
    }


}
