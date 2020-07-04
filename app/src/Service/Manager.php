<?php

namespace App\Service;

use App\Entity\BaseEntityInterface;
use App\Filter\FilterInterface;
use App\Repository\RepositoryInterface;

abstract class Manager
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param BaseEntityInterface $entity
     * @param bool $andFlush
     */
    public function update(BaseEntityInterface $entity, bool $andFlush = true): void
    {
        $this->repository->update($entity, $andFlush);
    }

    /**
     * @param BaseEntityInterface $entity
     */
    public function delete(BaseEntityInterface $entity): void
    {
        $this->repository->delete($entity);
    }

    /**
     * @param BaseEntityInterface $entity
     */
    public function flush(BaseEntityInterface $entity): void
    {
        $this->repository->flush($entity);
    }

    /**
     * @param FilterInterface $filter
     * @param int             $limit
     *
     * @return array
     */
    public function getByFilter(FilterInterface $filter, $limit = 0): array
    {
        return  $this->repository->findByFilter($filter, $limit);
    }

    /**
     * @param FilterInterface $filter
     *
     * @return int
     */
    public function countByFilter(FilterInterface $filter): int
    {
        return  $this->repository->countByFilter($filter);
    }

    /**
     * Start MySql transaction
     */
    public function beginTransaction(): void
    {
        $this->repository->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public function commitTransaction(): void
    {
        $this->repository->commitTransaction();
    }

    /**
     * rollBack transaction
     */
    public function rollBackTransaction(): void
    {
        $this->repository->rollBackTransaction();
    }
}
