<?php

namespace App\Services\Geocoding;

interface GeocoderInterface
{
    /**
     * Get coordinates for a given address.
     *
     * @param string $address
     * @return array
     */
    public function getCoordinates(string $address): array;
}
