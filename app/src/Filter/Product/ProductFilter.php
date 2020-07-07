<?php

namespace App\Filter\Product;

use App\Entity\Product\WeatherCondition;
use App\Filter\FilterInterface;

/**
 * Class ProductFilter
 * @package App\Filter\Product
 */
class ProductFilter implements FilterInterface
{
    /**
     * @var WeatherCondition|null
     */
    private $weatherCondition;

    /**
     * @return WeatherCondition|null
     */
    public function getWeatherCondition(): ?WeatherCondition
    {
        return $this->weatherCondition;
    }

    /**
     * @param WeatherCondition|null $weatherCondition
     */
    public function setWeatherCondition(?WeatherCondition $weatherCondition): void
    {
        $this->weatherCondition = $weatherCondition;
    }
}
