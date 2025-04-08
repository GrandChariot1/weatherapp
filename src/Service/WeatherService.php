<?php

namespace App\Service;

use App\Entity\Weather;

class WeatherService
{
    public function __construct(
        private WeatherApiClient $apiClient,
        private WeatherDataLogger $logger
    ) {
    }

    public function getWeatherData(string $city): Weather
    {
        try {
            $data = $this->apiClient->fetchWeatherData($city);

            if (isset($data['error'])) {
                throw new \RuntimeException($data['error']['message']);
            }

            $weather = new Weather(
                $data['location']['name'],
                $data['location']['country'],
                $data['current']['temp_c'],
                $data['current']['condition']['text'],
                $data['current']['humidity'],
                $data['current']['wind_kph'],
                new \DateTime($data['current']['last_updated'])
            );

            $this->logger->logWeatherData($weather);

            return $weather;
        } catch (\Exception $e) {
            throw new \RuntimeException('Weather data processing failed: '.$e->getMessage());
        }
    }
}