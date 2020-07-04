<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use App\Entity\BaseEntityInterface;
use App\Filter\FilterInterface;

/**
 * Class Repository
 * @package App\Repository
 */
abstract class Repository extends ServiceEntityRepository implements RepositoryInterface
{
    /**
     * @param BaseEntityInterface $entity
     * @param bool $andFlush
     *
     * @throws ORMException
     */
    public function update(BaseEntityInterface $entity,$andFlush = true)
    {
        $this->getEntityManager()->persist($entity);

        if ($andFlush) {
            $this->flush();
        }
    }

    /**
     * @param FilterInterface $filter
     * @param QueryBuilder $builder
     *
     * @return QueryBuilder
     */
    public function applyFilter(FilterInterface $filter, $builder)
    {
        return $builder;
    }

    /**
     * @param BaseEntityInterface $entity
     *
     * @throws ORMException
     */
    public function delete(BaseEntityInterface $entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->flush();
    }

    /**
     * @param null|BaseEntityInterface|array $entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function flush($entity = null)
    {
        $this->getEntityManager()->flush($entity);
    }

    /**
     * @param FilterInterface $filter
     * @param int             $limit
     *
     * @return array
     */
    public function findByFilter(FilterInterface $filter, $limit = 0)
    {
        $builder = $this->getQB($filter);

        if ($limit > 0) {
            $builder->setMaxResults($limit);
        }

        return $builder->getQuery()->getResult();
    }

    /**
     * @param FilterInterface $filter
     *
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countByFilter(FilterInterface $filter)
    {
        $builder = $this->getEntityManager()->createQueryBuilder();

        $builder
            ->select('count(t.id)')
            ->from($this->getClassName(), 't');

        $this->applyFilter($filter, $builder);

        return $builder->getQuery()->getSingleScalarResult();
    }

    /**
     * Start MySql transaction
     */
    public function beginTransaction()
    {
        $this->getEntityManager()->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public function commitTransaction()
    {
        $this->getEntityManager()->commit();
    }

    /**
     * rollBack transaction
     */
    public function rollBackTransaction()
    {
        $this->getEntityManager()->rollback();
    }

    /**
     * @param string $entity
     * @param $id
     *
     * @return object|null
     */
    public function getReference($entity, $id)
    {
        try {
            return $this->getEntityManager()->getReference($entity, $id);
        } catch (ORMException $ormException) {
            return null;
        }
    }
}
