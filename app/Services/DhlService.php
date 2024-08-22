<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class DhlService
{
    protected $client;


    public function __construct()
    {
        # API (Username / site ID) and API (Secret / Password)
        $username = '';
        $password = '';
        $encodedAuth = base64_encode("$username:$password");

        $this->client = new Client([
            'base_uri' => config('apisIntegration.DHL.prodURL'),
            'headers' => [
                'Authorization' => 'Basic ' . $encodedAuth,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function getRates($data)
    {
        try {
            $response = $this->client->post('rates', [
                'json' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $body = $response->getBody()->getContents();
            return $body;
        }
    }

    public function getPriceDetails($data)
    {
        try {
            $response = $this->client->post('landed-cost', [
                'json' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $body = $response->getBody()->getContents();
            dd(json_decode($body, true));
        }
    }

    public function createPickUpRequest($data)
    {
        try {
            $response = $this->client->post('pickups', [
                'json' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $body = $response->getBody()->getContents();
            return $body;
        }
    }

    public function createDomesticShipping($data)
    {
        try {
            $response = $this->client->post('shipments', [
                'json' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $body = $response->getBody()->getContents();
            return $body;
        }
    }

    public function createInternationalShipping($data)
    {
        try {
            $response = $this->client->post('shipments', [
                'json' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $body = $response->getBody()->getContents();
            return $body;
        }
    }

    public function validateAddress($queryParams)
    {
        try {
            $response = $this->client->get('address-validate?', [
                'query' => $queryParams
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $body = $response->getBody()->getContents();
            return $body;
        }
    }

    public function shipmentTracking($queryParams)
    {
        try {
            $response = $this->client->get('tracking', [
                'query' => $queryParams,
                'headers' => [
                    'Accept-Language' => $queryParams['Accept-Language'] ?? 'ara',
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $body = $response->getBody()->getContents();
            return $body;
        }
    }
}
