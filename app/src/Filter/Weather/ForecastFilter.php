<?php

namespace App\Filter\Weather;

use DateTime;
use App\Entity\Weather\City;
use App\Filter\FilterInterface;

/**
 * Class ForecastFilter
 * @package App\Filter\Weather
 */
class ForecastFilter implements FilterInterface
{
    /**
     * @var City|null
     */
    private $city;

    /**
     * @var DateTime|null
     */
    private $time;

    /**
     * @return City|null
     */
    public function getCity(): ?City
    {
        return $this->city;
    }

    /**
     * @param City|null $city
     */
    public function setCity(?City $city): void
    {
        $this->city = $city;
    }

    /**
     * @return DateTime|null
     */
    public function getTime(): ?DateTime
    {
        return $this->time;
    }

    /**
     * @param DateTime|null $time
     */
    public function setTime(?DateTime $time): void
    {
        $this->time = $time;
    }
}
