<?php

namespace Mursalov\Logger;


use DateTime;
use Mursalov\Logger\interfaces\WriterInterface;
use Psr\Log\AbstractLogger;

/**
 * Logger to write log in db file and more.
 */
class Logger extends AbstractLogger
{
    /**
     * Array writers which write log.
     *
     * @var array
     */
    private array $writers;

    public function __construct(WriterInterface $writer)
    {
        $this->writers = [];
        $this->writers[] = $writer;
    }

    /**
     * Write log !!!
     * @param $level
     * @param \Stringable|string $message
     * @param array $context
     * @return void
     */
    public function log($level, \Stringable|string $message, array $context = []): void
    {
        $date = new DateTime();
        foreach ($this->writers as $writer) {
            $writer->write($date, $level, $message, $context);
        }
    }

    /**
     * Add writer to writer array.
     *
     * @param $writer
     * @return void
     */
    public function setWriter($writer): void
    {
        $this->writers[] = $writer;
    }
}