<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\{ConsoleEvent, ConsoleCommandEvent, ConsoleErrorEvent, ConsoleTerminateEvent};
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Command\CliCommandInterface;

/**
 * Class CliExceptionListener
 * @package App\EventListener
 */
class CliExceptionListener implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $cliLogger;

    /**
     * @param LoggerInterface $cliLogger
     */
    public function __construct(LoggerInterface $cliLogger)
    {
        $this->cliLogger = $cliLogger;
    }

    /**
     * @return array|string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ConsoleEvents::ERROR => 'onConsoleError',
            ConsoleEvents::TERMINATE => 'onConsoleTerminate',
            ConsoleEvents::COMMAND => 'onConsoleCommand',
        ];
    }

    /**
     * @param ConsoleErrorEvent $event
     */
    public function onConsoleError(ConsoleErrorEvent $event): void
    {
        if (!$this->isCorrectCommand($event)) {
            return;
        }

        $output = $event->getOutput();
        $command = $event->getCommand();
        $error = $event->getError();

        $output->writeln(sprintf('Error while running <info>%s</info>', $command->getName()));
        $output->writeln(sprintf('Error message <error>%s</error>', $error->getMessage()));
        $this->cliLogger->error($command->getName(), ['command' => $command->getName(), 'error' => $error]);
        $event->setExitCode(0);
    }

    /**
     * @param ConsoleTerminateEvent $event
     */
    public function onConsoleTerminate(ConsoleTerminateEvent $event): void
    {
        if (!$this->isCorrectCommand($event)) {
            return;
        }

        $command = $event->getCommand();
        $this->cliLogger->info(sprintf('Command %s executed', $command->getName()));
    }

    /**
     * @param ConsoleCommandEvent $event
     */
    public function onConsoleCommand(ConsoleCommandEvent $event): void
    {
        if (!$this->isCorrectCommand($event)) {
            return;
        }

        $command = $event->getCommand();
        $this->cliLogger->info(sprintf('Command %s started', $command->getName()));
    }

    /**
     * @param ConsoleEvent $event
     *
     * @return bool
     */
    protected function isCorrectCommand(ConsoleEvent $event): bool
    {
        $command = $event->getCommand();

        if (null === $command) {
            return false;
        }

        if (!$command instanceof CliCommandInterface) {
            return false;
        }

        return true;
    }
}
