<?php

namespace App\Entity;

use DateTimeInterface;

class Weather
{
    public function __construct(
        private string $city,
        private string $country,
        private float $temperature,
        private string $condition,
        private int $humidity,
        private float $windSpeed,
        private DateTimeInterface $lastUpdated
    ) {
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function getCondition(): string
    {
        return $this->condition;
    }

    public function getHumidity(): int
    {
        return $this->humidity;
    }

    public function getWindSpeed(): float
    {
        return $this->windSpeed;
    }

    public function getLastUpdated(): DateTimeInterface
    {
        return $this->lastUpdated;
    }
}