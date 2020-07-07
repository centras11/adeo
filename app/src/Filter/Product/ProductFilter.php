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
     * @var string|null
     */
    private $weatherCondition;

    /**
     * @return string|null
     */
    public function getWeatherCondition(): ?string
    {
        return $this->weatherCondition;
    }

    /**
     * @param string|null $weatherCondition
     */
    public function setWeatherCondition(?string $weatherCondition): void
    {
        $this->weatherCondition = $weatherCondition;
    }
}
