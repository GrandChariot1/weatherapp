<?php

namespace App\Controller;

use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{
    #[Route('/weather/{city}', name: 'weather_show')]
    public function show(string $city, WeatherService $weatherService): Response
    {
        try {
            $weather = $weatherService->getWeatherData($city);

            return $this->render('weather/show.html.twig', [
                'weather' => $weather,
            ]);
        } catch (\RuntimeException $e) {
            return new JsonResponse(
                ['error' => $e->getMessage()],
                Response::HTTP_SERVICE_UNAVAILABLE
            );
        }
    }
}
