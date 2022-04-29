<?php

namespace Mursalov\Logger;

use Mursalov\Logger\interfaces\FormatterInterface;
use Mursalov\Logger\interfaces\WriterInterface;

class DbWriter implements WriterInterface
{
    private FormatterInterface $formatter;
    private \PDO $dbh;

    /**
     * @param \PDO $dbh
     */
    public function __construct(FormatterInterface $formatter, \PDO $dbh)
    {
        $this->formatter = $formatter;
        $this->dbh = $dbh;
        $query = 'create table IF NOT EXISTS logs(
                    log_id int auto_increment,
                    log_date datetime default null,
                    log_level varchar(10) default null,
                    log_message varchar(500) default NULL,
                    log_context TEXT default null,
                    primary key(log_id)


                );';
        $dbh->exec($query);
    }

    public function write($logDate, $level, \Stringable|string $message, array $context = []): void
    {
        $logInfo = $this->formatter->format($logDate, $level, $message, $context);
        $query = 'INSERT INTO logs (log_date, log_level, log_message, log_context) 
                    VALUE (:log_date, :log_level, :log_message, :log_context)';
        $stmt = $this->dbh->prepare($query);
        $stmt->execute($logInfo);
    }
}