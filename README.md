# DHL Shipping Integration with Laravel

 This project provides an integration with DHL for shipping functionalities using the PHP Laravel framework. It includes services, request builders, controllers, and routes to facilitate interactions with DHL's API.

# Project Structure
* Services: Contains logic for interacting with the DHL API, including methods for getting rates, creating shipments, and handling other DHL-specific functionalities.

* Request Builders: Provides methods to construct and format the data required by DHL's API. This includes setting shipment details, customer information, and other relevant parameters.

* Controllers: Handles incoming requests, uses the service layer to process these requests, and returns responses to the client.

* Routes: Defines the API endpoints and maps them to the appropriate controllers and methods

# Service
The Service layer handles API calls to DHL. It uses the Request Builder to format the request and sends it to DHL's API. You can use methods like:

1.  getRates(): Retrieves shipping rates from DHL.
2. getPriceDetails(): Gets landed cost details for shipments.
3. createPickUpRequest(): Creates a pickup request with DHL.
4. createDomesticShipping(): Creates a domestic shipment with DHL.
5. createInternationalShipping(): Creates an international shipment with DHL.
6. validateAddress(): Validates an address using DHL's address validation service.
7. shipmentTracking(): Tracks a shipment using DHL's tracking service.

# Controller
The Controller handles incoming HTTP requests, utilizes the Service layer to perform actions, and returns responses. It routes requests to the appropriate methods in the Service layer.
