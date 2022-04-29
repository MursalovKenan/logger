<?php

namespace Mursalov\Logger;

use Mursalov\Logger\interfaces\FormatterInterface;
use Mursalov\Logger\interfaces\WriterInterface;

class FileWriter implements WriterInterface
{
    private string $fileName;
    private string $filePath;
    private FormatterInterface $Formatter;

    public function __construct(FormatterInterface $Formatter,
                                string $filePath = __DIR__ . '/logs/',
                                $fileName = 'log.txt')
    {
        $this->Formatter = $Formatter;
        $this->fileName = $fileName;
        $this->filePath = $filePath;
    }

    public function write($logDate, $level, \Stringable|string $message, array $context = []): void
    {
        $logInfo = $this->Formatter->format($logDate, $level, $message, $context);
        $logLine = implode(' | ', $logInfo);
        $logLine .= PHP_EOL;
        $filePath = $this->filePath;
        if (!file_exists($filePath)) {
            mkdir($filePath);
        }
        $fileName = $this->fileName;
        file_put_contents($filePath . $fileName, $logLine,  FILE_APPEND | LOCK_EX);
    }
    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }

    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }
}