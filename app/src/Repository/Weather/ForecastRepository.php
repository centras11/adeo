<?php

namespace App\Repository\Weather;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use App\Entity\Weather\Forecast;
use App\Filter\FilterInterface;
use App\Filter\Weather\ForecastFilter;
use App\Repository\Repository;

/**
 * Class ForecastRepository
 * @package App\Repository\Weather
 */
class ForecastRepository extends Repository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Forecast::class);
    }

    /**
     * @inheritDoc
     */
    public function getQB(FilterInterface $filter): QueryBuilder
    {
        $builder = $this->getEntityManager()->createQueryBuilder();
        $builder
            ->select('f')
            ->from(Forecast::class, 'f')
            ->leftJoin('f.city', 'c');

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
        /** @var ForecastFilter $filter */

        if (null !== $filter->getCity()) {
            $builder
                ->andWhere('f.city = :city')
                ->setParameter('city', $filter->getCity());
        }

        if (null !== $filter->getTime()) {
            $builder
                ->andWhere('f.forecastTimeUtc = :forecastTimeUtc')
                ->setParameter('forecastTimeUtc', $filter->getTime());
        }

        return $builder;
    }

    /**
     * @param ForecastFilter $filter
     *
     * @return Forecast|null
     * @throws NonUniqueResultException
     */
    public function findOneByFilter(ForecastFilter $filter): ?Forecast
    {
        $builder = $this->getQB($filter);
        $builder->setMaxResults(1);

        return $builder->getQuery()->getOneOrNullResult();
    }
}
