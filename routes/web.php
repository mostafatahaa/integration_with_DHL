<?php

use App\Http\Controllers\DHLController;
use App\Http\Controllers\FedExController;
use Illuminate\Support\Facades\Route;

# DHL routes
Route::get('/dhl-rating', [DHLController::class, 'dhlGetRating']);
//Route::get('/dhl-create-pickup-request', [DHLController::class, 'dhlCreatePickUpRequest']);
//Route::get('/dhl-create-domestic-shipment', [DHLController::class, 'dhlCreateDomesticShipping']);
//Route::get('/dhl-create-international-shipment', [DHLController::class, 'createInternationalShipment']);
Route::get('/dhl-address-validation', [DHLController::class, 'dhlAddressValidation']);
//Route::get('/dhl-tracking-status', [DHLController::class, 'dhlTrackingStatus']);
Route::get('/dhl-land-cost', [DHLController::class, 'dhlGetLandCost']);

# FedEx routes

Route::controller(FedExController::class)->group(function () {
    Route::get('fedex-rating', 'fedexGetRates');
    Route::get('fedex-rating-test', 'fedexGetRatesTest');
    Route::get('fedex-check-pickup-availability', 'fedexPickupAvailability');
    Route::get('fedex-create-pickup-request', 'fedexCreatePickUpRequest');
});

