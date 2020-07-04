<?php

namespace App\Filter\Weather;

use App\Filter\FilterInterface;

/**
 * Class ForecastFilter
 * @package App\Filter\Weather
 */
class ForecastFilter implements FilterInterface
{
    /**
     * @var string|null
     */
    private $city;

    /**
     * @var string|null
     */
    private $time;

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getTime(): ?string
    {
        return $this->time;
    }

    /**
     * @param string|null $time
     */
    public function setTime(?string $time): void
    {
        $this->time = $time;
    }
}
