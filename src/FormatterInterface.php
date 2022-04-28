<?php

namespace Mursalov\Logger;

interface FormatterInterface
{
    public function format($level, \Stringable|string $message, array $context = []);
}