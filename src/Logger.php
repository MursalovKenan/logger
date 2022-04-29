<?php

namespace Mursalov\Logger;


use DateTime;
use Mursalov\Logger\interfaces\WriterInterface;
use Psr\Log\AbstractLogger;

class Logger extends AbstractLogger
{
    private array $writers;

    public function __construct(WriterInterface $writer)
    {
        $this->writers = [];
        $this->writers[] = $writer;
    }


    public function log($level, \Stringable|string $message, array $context = []): void
    {
        $date = new DateTime();
        foreach ($this->writers as $writer) {
            $writer->write($date, $level, $message, $context);
        }
    }

    public function setWriter($writer): void
    {
        $this->writers[] = $writer;
    }
}