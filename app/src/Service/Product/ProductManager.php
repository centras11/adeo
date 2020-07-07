<?php

namespace App\Service\Product;

use App\Entity\Weather\City;
use App\Filter\Product\ProductFilter;
use App\Repository\Product\ProductRepository;
use App\Service\Manager;
use App\Service\Weather\ForecastManager;

/**
 * Class ProductManager
 * @package App\Service\Product
 */
class ProductManager extends Manager
{
    public const PRODUCT_RECOMMENDATION_LIMIT = 5;

    /** @var ProductFilter */
    private $productFilter;

    /** @var ProductRepository */
    private $productRepository;

    /** @var ForecastManager */
    private $forecastManager;

    /**
     * ProductManager constructor.
     *
     * @param ProductFilter $productFilter
     * @param ProductRepository $productRepository
     * @param ForecastManager $forecastManager
     */
    public function __construct(
        ProductFilter $productFilter,
        ProductRepository $productRepository,
        ForecastManager $forecastManager
    )
    {
        parent::__construct($productRepository);
        $this->productRepository = $productRepository;
        $this->productFilter = $productFilter;
        $this->forecastManager = $forecastManager;
    }

    public function getRecommendationByCity(City $city): array
    {
        $return = [];
        $forecast = $this->forecastManager->getCurrentForecast($city);

        $return['city'] = $city->getCity();
        $return['current_weather'] = $forecast->getConditionCode();

        $this->productFilter->setWeatherCondition($forecast->getConditionCode());
        $return['recommended_products'] = $this->getByFilter($this->productFilter, self::PRODUCT_RECOMMENDATION_LIMIT);

        return $return;
    }
}
