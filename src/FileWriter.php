<?php

namespace Mursalov\Logger;

class FileWriter implements WriterInterface
{
    private string $fileName;
    private FormatterInterface $Formatter;

    public function __construct(FormatterInterface $Formatter, string $fileName = __DIR__ . '/logs/log.txt')
    {
        $this->Formatter = $Formatter;
        $this->fileName = $fileName;
    }
    public function write($level, \Stringable|string $message, array $context = []): void
    {
        $logLine = $this->Formatter->format($level, $message, $context);
        file_put_contents($this->fileName, $logLine,  FILE_APPEND | LOCK_EX);
    }
    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }


}