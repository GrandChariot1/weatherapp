<?php

namespace App\Tests\Service;

use App\Entity\Weather;
use App\Service\WeatherApiClient;
use App\Service\WeatherDataLogger;
use App\Service\WeatherService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class WeatherServiceTest extends TestCase
{
    public function testGetWeatherData(): void
    {
        $mockResponse = new MockResponse(json_encode([
            'location' => [
                'name' => 'London',
                'country' => 'UK',
            ],
            'current' => [
                'temp_c' => 15.5,
                'condition' => ['text' => 'Partly cloudy'],
                'humidity' => 65,
                'wind_kph' => 12.3,
                'last_updated' => '2023-05-01 12:00',
            ],
        ], JSON_THROW_ON_ERROR));

        $httpClient = new MockHttpClient($mockResponse);
        $apiClient = new WeatherApiClient($httpClient, 'test_key');

        $logger = $this->createMock(WeatherDataLogger::class);
        $logger->expects($this->once())
            ->method('logWeatherData');

        $service = new WeatherService($apiClient, $logger);
        $weather = $service->getWeatherData('London');

        $this->assertInstanceOf(Weather::class, $weather);
        $this->assertEquals('London', $weather->getCity());
        $this->assertEquals(15.5, $weather->getTemperature());
    }
}