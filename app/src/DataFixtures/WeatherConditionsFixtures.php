<?php

namespace App\DataFixtures;

use App\Entity\Product\WeatherCondition;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class WeatherConditionsFixtures
 * @package App\DataFixtures
 */
class WeatherConditionsFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        // Disable SQL Logging
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        $csv = fopen(__DIR__ . '/Resources/weatherConditions.csv', 'rb');
        $i = 0;

        while (!feof($csv)) {
            ++$i;
            $line = fgetcsv($csv);

            // skipping first line - header
            if (1 === $i || false === $line) {
                continue;
            }

            $weatherCondition = new WeatherCondition();
            $weatherCondition->setTitle($line[0]);

            $manager->persist($weatherCondition);
            $this->addReference("weatherCondition_{$i}", $weatherCondition);

            if ($i % 25 === 0) {
                $manager->flush();
                $manager->clear();

            }
        }

        fclose($csv);

        $manager->flush();
        $manager->clear();
    }
}
