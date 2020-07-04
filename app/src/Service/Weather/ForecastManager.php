<?php

namespace App\Service\Weather;

use App\Entity\Weather\Forecast;
use App\Filter\Weather\ForecastFilter;
use App\Repository\Weather\ForecastRepository;
use App\Service\Manager;

/**
 * Class ForecastManager
 * @package App\Service\Weather
 */
class ForecastManager extends Manager
{
    /** @var ForecastFilter */
    private $forecastFilter;

    /** @var ForecastRepository */
    private $forecastRepository;

    /**
     * ForecastManager constructor.
     *
     * @param ForecastFilter $forecastFilter
     * @param ForecastRepository $forecastRepository
     */
    public function __construct(ForecastFilter $forecastFilter, ForecastRepository $forecastRepository)
    {
        parent::__construct($forecastRepository);
        $this->forecastFilter = $forecastFilter;
        $this->forecastRepository = $forecastRepository;
    }

    public function insertOrUpdate(Forecast $forecast): Forecast
    {
        $this->forecastFilter->setTime($forecast->getForecastTimeUtc());
        $this->forecastFilter->setCity($forecast->getCity());

        $search = $this->forecastRepository->findOneByFilter($this->forecastFilter);

        if (null === $search) {
            // updating

            return $search;
        }

        // insert

        return $forecast;
    }
}
