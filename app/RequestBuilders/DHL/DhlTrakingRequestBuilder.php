<?php

namespace App\RequestBuilders\DHL;

use InvalidArgumentException;

class DhlTrakingRequestBuilder
{
    private $data = [];


    public function setTrackingNumber($trackingNumber)
    {
        $this->data['shipmentTrackingNumber'] = $trackingNumber;
        return $this;
    }

    public function setLanguage($language)
    {
        $this->data['Accept-Language'] = $language;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }
}

