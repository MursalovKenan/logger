<?php

namespace Mursalov\Logger\interfaces;

interface FormatterInterface
{
    public function format($logDate, $logLevel, \Stringable|string $message, array $context = []);
    public function formatLogDate($logDate, $dateFormat): string;
    public function formatLogLevel ($logLevel): string;
    public function formatLogMessage($logMessage): string;
    public function formatLogContext($logContext): ?string;
}