<?php

namespace App\utils;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;

require_once __DIR__ . '/../../vendor/autoload.php';

class RacoinLogger {
    
    function __construct(string $message, string $level, string $fileName) {
        $logLevels = [
            'emergency' => Level::Emergency,
            'alert'     => Level::Alert,
            'critical'  => Level::Critical,
            'error'     => Level::Error,
            'warning'   => Level::Warning,
            'notice'    => Level::Notice,
            'info'      => Level::Info,
            'debug'     => Level::Debug,
        ];

        $logger = new Logger('racoin.logs');
        $logger->pushHandler(
            new StreamHandler($fileName, $logLevels[$level] ?? Level::Notice)
        );
        $logger->log($logLevels[$level], $message);
    }
}
