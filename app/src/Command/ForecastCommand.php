<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\Weather\ForecastManager;

/**
 * Class ForecastCommand
 * @package App\Command
 */
class ForecastCommand extends Command implements CliCommandInterface
{
    protected static $defaultName = 'app:forecast';

    /**
     * @var ForecastManager
     */
    private $forecastManager;

    /**
     * @param ForecastManager $forecastManager
     */
    public function __construct(ForecastManager $forecastManager)
    {
        parent::__construct();
        $this->forecastManager = $forecastManager;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Gets forecast from meteo.lt.')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->forecastManager->getForecast();
        $output->writeln('Command executed.');

        return 0;
    }
}
