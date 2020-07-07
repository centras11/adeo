<?php

namespace App\Service\Weather;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Weather\{City, Forecast};
use App\Filter\Weather\ForecastFilter;
use App\Repository\Weather\ForecastRepository;
use App\Service\Manager;

/**
 * Class ForecastManager
 * @package App\Service\Weather
 */
class ForecastManager extends Manager
{
    public const METEO_API_LINK = 'https://api.meteo.lt/v1/places/%s/forecasts/long-term';

    /** @var ForecastFilter */
    private $forecastFilter;

    /** @var ForecastRepository */
    private $forecastRepository;

    /** @var HttpClientInterface */
    private $httpClient;

    /** @var CityManager */
    private $cityManager;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * ForecastManager constructor.
     *
     * @param ForecastFilter $forecastFilter
     * @param ForecastRepository $forecastRepository
     * @param HttpClientInterface $httpClient
     * @param CityManager $cityManager
     * @param SerializerInterface $serializer
     */
    public function __construct(
        ForecastFilter $forecastFilter,
        ForecastRepository $forecastRepository,
        HttpClientInterface $httpClient,
        CityManager $cityManager,
        SerializerInterface $serializer
    )
    {
        parent::__construct($forecastRepository);
        $this->forecastFilter = $forecastFilter;
        $this->forecastRepository = $forecastRepository;
        $this->httpClient = $httpClient;
        $this->cityManager = $cityManager;
        $this->serializer = $serializer;
    }

    private function insertOrUpdate(Forecast $forecast): Forecast
    {
        $this->forecastFilter->setTime($forecast->getForecastTimeUtc());
        $this->forecastFilter->setCity($forecast->getCity());

        $search = $this->forecastRepository->findOneByFilter($this->forecastFilter);

        if (null !== $search) {
            // update
            $search->setConditionCode($forecast->getConditionCode());
            $this->update($search);

            return $search;
        }

        // insert
        $this->update($forecast);

        return $forecast;
    }

    /**
     * @param City $city
     *
     * @return array
     */
    private function doRequestToMeteo(City $city): array
    {
        $apiLink =  sprintf(self::METEO_API_LINK, $city->getCity());
        $response = $this->httpClient->request('GET', $apiLink);
        $content = $response->getContent();
        $forecastTimestamps = json_decode($content, true);

        return $forecastTimestamps['forecastTimestamps'];
    }

    // @todo - make concurrent requests: https://symfony.com/doc/current/http_client.html#concurrent-requests
    /**
     * @return bool
     */
    public function getForecast(): bool
    {
        $cities = $this->cityManager->getAll();

        foreach ($cities as $city) {
            /** @var City $city */
            $content = $this->doRequestToMeteo($city);

            foreach ($content as $forecastTimestamp) {
                /** @var Forecast $forecast */
                $forecast = $this->serializer->deserialize(
                    json_encode($forecastTimestamp),
                    Forecast::class,
                    'json'
                );
                $forecast->setCity($city);
                $this->insertOrUpdate($forecast);
            }
        }

        return true;
    }
}
