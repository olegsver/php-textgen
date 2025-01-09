<?php

namespace AI\service;

use Illuminate\Container\Container;

class CommandService
{
    private Container $container;

    private const NO_COMMAND_MESSAGE = 'Usage: php index.php <command> <commandArg>';

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->container->singleton(ModelService::class);
    }

    public function run(array $args): string
    {
        if (empty($args[1]) || empty($args[2])) {
            return $this->outMessage(self::NO_COMMAND_MESSAGE);
        }

        return $this->outMessage(
            $this->runCommand($args[1], $args[2])
        );
    }

    private function runCommand(string $command, string $commandArg): string
    {
        $commandService = $this->makeCommandServiceByCommand($command);
        if ($commandService) {
            return $commandService->run($commandArg);
        }

        return "Unknown command: $command" . PHP_EOL;
    }

    /**
     * Resolves the appropriate command service based on the command name.
     *
     * @param string $commandName
     *
     * @return CommandServiceInterface|null
     */
    private function makeCommandServiceByCommand(string $commandName): ?CommandServiceInterface
    {
        switch ($commandName) {
            case 'learn':
                return $this->container->make(LearnService::class);
            case 'predict':
                return $this->container->make(PredictService::class);
            default:
                return null;
        }
    }

    /**
     * @param string $message
     *
     * @return string
     */
    private function outMessage(string $message): string
    {
        return sprintf('%s%s', $message, PHP_EOL);
    }
}