<?php

namespace App\Service\Weather;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use App\Entity\Weather\City;

/**
 * Class CityManager
 * @package App\Service\Weather
 */
class CityManager
{
    /**
     * @var EntityManagerInterface
     */
    private $objectManager;

    /**
     * @param EntityManagerInterface $objectManager
     */
    public function __construct(EntityManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->getRepository()->findAll();
    }


    /**
     * @return ObjectRepository
     */
    private function getRepository(): ObjectRepository
    {
        return $this->objectManager->getRepository(City::class);
    }
}
