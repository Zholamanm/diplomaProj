<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeoapifyService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.geoapify.com/v2/places';

    public function __construct()
    {
        $this->apiKey = config('services.geoapify.key');
    }

    /**
     * Get nearby coffee shops by coordinates
     *
     * @param float $latitude
     * @param float $longitude
     * @param int $radius in meters
     * @param int $limit
     * @return array
     */
    public function getNearbyCoffeeShops(float $latitude, float $longitude, int $radius = 5000, int $limit = 7): array
    {
        $response = Http::get($this->baseUrl, [
            'categories' => 'catering.cafe',
            'filter' => "circle:$longitude,$latitude,$radius",
            'bias' => "proximity:$longitude,$latitude",
            'limit' => $limit,
            'apiKey' => $this->apiKey,
        ]);

        if ($response->successful()) {
            return $response->json('features') ?? [];
        }

        // Optionally log errors here
        return [];
    }
}
