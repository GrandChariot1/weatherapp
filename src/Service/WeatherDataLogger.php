<?php

namespace App\Service;

use App\Entity\Weather;

class WeatherDataLogger
{
    public function __construct(private string $logFilePath)
    {
    }

    public function logWeatherData(Weather $weather): void
    {
        $logMessage = sprintf(
            "%s - Погода в %s: %.1f°C, %s\n",
            date('Y-m-d H:i:s'),
            $weather->getCity(),
            $weather->getTemperature(),
            $weather->getCondition()
        );

        file_put_contents($this->logFilePath, $logMessage, FILE_APPEND);
    }
}