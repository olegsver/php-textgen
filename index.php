<?php

require_once __DIR__ . '/vendor/autoload.php';

use AI\service\CommandService;
use Illuminate\Container\Container;

try {
    // Initialize the container
    $container = new Container();
    $command   = new CommandService($container);
    echo $command->run($argv ?? []);
} catch (\Throwable $e) {
    // Global exception handling
    error_log($e->getMessage());
    error_log($e->getTraceAsString());
    echo sprintf("An unexpected error occurred: %s%s", $e->getMessage(), PHP_EOL);
    exit(1);
}