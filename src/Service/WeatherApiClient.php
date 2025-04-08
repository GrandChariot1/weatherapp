<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherApiClient
{
    public function __construct(
        private HttpClientInterface $client,
        private string $weatherApiKey,
        private string $weatherApiUrl = 'https://api.weatherapi.com/v1/'
    ) {
    }

    public function fetchWeatherData(string $city): array
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->weatherApiUrl . 'current.json',
                [
                    'query' => [
                        'key' => $this->weatherApiKey,
                        'q' => $city,
                    ],
                    'timeout' => 30,
                ]
            );

            return $response->toArray();
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to fetch weather data: '.$e->getMessage());
        }
    }
}