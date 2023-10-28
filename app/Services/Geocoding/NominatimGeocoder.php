<?php

namespace App\Services\Geocoding;

use GuzzleHttp\Client;

class NominatimGeocoder implements GeocoderInterface
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://nominatim.openstreetmap.org/']);
    }

    /**
     * GGet all possible coordinates for a given address.
     *
     * @param string $address
     * @return array
     */
    public function getCoordinates(string $address): array
    {
        $response = $this->client->get('search', [
            'query' => [
                'q' => $address,
                'addressdetails' => 1,
                'format' => 'json',
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        if (empty($data)) {
            return [];
        }

        return $data;
    }
}
