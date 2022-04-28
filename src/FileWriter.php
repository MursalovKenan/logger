<?php

namespace Mursalov\Logger;

class FileWriter implements WriterInterface
{
    private string $fileName;
    private string $filePath;
    private FormatterInterface $Formatter;

    public function __construct(FormatterInterface $Formatter, string $filePath = __DIR__ . '/logs/')
    {
        $this->Formatter = $Formatter;
        $this->fileName = 'log.txt';
        $this->$filePath = $filePath;
    }
    public function write($level, \Stringable|string $message, array $context = []): void
    {
        $logLine = $this->Formatter->format($level, $message, $context);
        $filePath = $this->filePath;
        if (!mkdir($filePath) && !is_dir($filePath)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $filePath));
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