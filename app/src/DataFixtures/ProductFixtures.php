<?php

namespace App\DataFixtures;

use App\Entity\Product\Product;
use App\Entity\Product\WeatherCondition;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        $numberOfProducts = 100;
        $numberOfWeatherConditions = 3;

        // Disable SQL Logging
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        for ($i = 1; $i <= $numberOfProducts; $i++) {
            $product = new Product();
            $product->setTitle($faker->company);
            $product->setSku($faker->isbn10);

            for ($i2 = 1; $i2 <= $numberOfWeatherConditions; $i2++) {
                $rand = random_int(2, 12);
                /** @var WeatherCondition $weatherCondition */
                $weatherCondition = $this->getReference("weatherCondition_{$rand}");
                $product->addWeatherCondition($weatherCondition);
            }

            $manager->persist($product);

            if ($i % 25 === 0) {
                $manager->flush();
                $manager->clear();

            }
        }

        $manager->flush();
        $manager->clear();
    }

    public function getDependencies(): array
    {
        return [
            WeatherConditionsFixtures::class,
        ];
    }
}
