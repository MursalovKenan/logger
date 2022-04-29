<?php

namespace Mursalov\Logger\interfaces;

interface WriterInterface
{
    public function write($logDate, $level, \Stringable|string $message, array $context = []);
}