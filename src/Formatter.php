<?php

namespace Mursalov\Logger;


class Formatter implements FormatterInterface
{
    public const LOG_DATE = '{date}';
    public const LOG_LEVEL = '{level}';
    public const LOG_MESSAGE = '{message}';
    public const LOG_CONTEXT = '{context}';
    public string $format;

    public function __construct($format = '{date} {level} {message} {context}')
    {
        $this->format = $format;
    }

    /**
     * @throws \JsonException
     */
    public function format($level, \Stringable|string $message, array $context = []): string
    {
        $logInfo = '';
        $formatParams = explode(' ', $this->format);
        foreach ($formatParams as $formatParam) {
            switch ($formatParam) {
                case self::LOG_DATE :
                    $dateFormat = 'Y-m-d H:i:s';
                    $logDate = date($dateFormat);
                    $logInfo .= $logDate . ' ';
                    break;
                case self::LOG_LEVEL :
                    $logInfo .= strtoupper($level) . ' ';
                    break;
                case self::LOG_MESSAGE:
                    $logInfo .= $message . ' ';
                    break;
                case self::LOG_CONTEXT:
                    $logInfo .= serialize($context);
            }
        }
        $logInfo .=PHP_EOL;
        return $logInfo;
    }
}