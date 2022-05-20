<?php

namespace Mursalov\Logger;


use Mursalov\Logger\interfaces\FormatterInterface;

/**
 * Format log data.
 */
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
     * Return array with formatter log data.
     *
     * @param $logDate
     * @param $logLevel
     * @param \Stringable|string $message
     * @param array $context
     * @return array
     */
    public function format($logDate, $logLevel, \Stringable|string $message, array $context = []): array
    {
        $logInfo = [];
        $formatParams = explode(' ', $this->format);
        foreach ($formatParams as $formatParam) {
            switch ($formatParam) {
                case self::LOG_DATE :
                    $logInfo ['log_date'] = $this->formatLogDate($logDate);
                    break;
                case self::LOG_LEVEL :
                    $logInfo ['log_level'] = $this->formatLogLevel($logLevel);
                    break;
                case self::LOG_MESSAGE:
                    $logInfo ['log_message'] = $this->formatLogMessage($message);
                    break;
                case self::LOG_CONTEXT:
                    $logInfo ['log_context'] = $this->formatLogContext($context);
                    break;
            }
        }
        return $logInfo;
    }

    /**
     * Format log date.
     * @param $logDate
     * @param $dateFormat
     * @return string
     */
    public function formatLogDate($logDate, $dateFormat = 'Y-m-d H:i:s'): string
    {
        return date($dateFormat);
    }

    /**
     * Format log level.
     *
     * @param $logLevel
     * @return string
     */
    public function formatLogLevel ($logLevel): string
    {
        return strtoupper($logLevel);
    }

    /**
     * Format log message
     * @param $logMessage
     * @return string
     */
    public function formatLogMessage($logMessage): string
    {
        return trim($logMessage);
    }

    /**
     * Format log context
     *
     * @param $logContext
     * @return string|null
     */
    public function formatLogContext($logContext): ?string
    {
        if (is_array($logContext) && !empty($logContext)) {
            return serialize($logContext);
        }
        return null;
    }
}