<?php

namespace App\Repository\Product;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use App\Entity\Product\Product;
use App\Filter\FilterInterface;
use App\Filter\Product\ProductFilter;
use App\Repository\Repository;

/**
 * Class ProductRepository
 * @package App\Repository\Product
 */
class ProductRepository extends Repository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @inheritDoc
     */
    public function getQB(FilterInterface $filter): QueryBuilder
    {
        $builder = $this->getEntityManager()->createQueryBuilder();
        $builder
            ->select('p')
            ->from(Product::class, 'p')
            ->leftJoin('p.weatherConditions', 'wc');

        $this->applyFilter($filter, $builder);

        return $builder;
    }

    /**
     * @param FilterInterface $filter
     * @param QueryBuilder    $builder
     *
     * @return QueryBuilder
     */
    public function applyFilter(FilterInterface $filter, $builder): QueryBuilder
    {
        /** @var ProductFilter $filter */

        if (null !== $filter->getWeatherCondition()) {
            $builder
                ->andWhere('p.weatherConditions = :weatherCondition')
                ->setParameter('weatherCondition', $filter->getWeatherCondition());
        }

        return $builder;
    }
}
