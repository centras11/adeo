<?php

namespace App\Service\Product;

use App\Filter\Product\ProductFilter;
use App\Repository\Product\ProductRepository;
use App\Service\Manager;

/**
 * Class ProductManager
 * @package App\Service\Product
 */
class ProductManager extends Manager
{
    /** @var ProductFilter */
    private $productFilter;

    /** @var ProductRepository */
    private $productRepository;

    /**
     * ProductManager constructor.
     *
     * @param ProductFilter $productFilter
     * @param ProductRepository $productRepository
     */
    public function __construct(
        ProductFilter $productFilter,
        ProductRepository $productRepository
    )
    {
        parent::__construct($productRepository);
        $this->productRepository = $productRepository;
        $this->productFilter = $productFilter;
    }
}
