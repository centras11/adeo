<?php

namespace App\Repository;

use Doctrine\ORM\QueryBuilder;
use App\Entity\BaseEntityInterface;
use App\Filter\FilterInterface;

interface RepositoryInterface
{
    /**
     * @param FilterInterface $filter
     *
     * @return QueryBuilder
     */
    public function getQB(FilterInterface $filter);

    /**
     * @param BaseEntityInterface $entity
     * @param bool $andFlush
     */
    public function update(BaseEntityInterface $entity, $andFlush = true);

    /**
     * @param BaseEntityInterface $entity
     */
    public function delete(BaseEntityInterface $entity);

    /**
     * @param null|BaseEntityInterface|array $entity
     *
     * @return void
     */
    public function flush($entity = null);

    /**
     * @param FilterInterface $filter
     * @param int             $limit
     *
     * @return array
     */
    public function findByFilter(FilterInterface $filter, $limit = 0);

    /**
     * @param FilterInterface $filter
     *
     * @return int
     */
    public function countByFilter(FilterInterface $filter);

    /**
     * Start MySql transaction
     */
    public function beginTransaction();

    /**
     * Commit transaction
     */
    public function commitTransaction();

    /**
     * rollBack transaction
     */
    public function rollBackTransaction();
}
