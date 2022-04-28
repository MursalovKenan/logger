<?php

namespace Mursalov\Logger;

interface WriterInterface
{
    public function write($level, \Stringable|string $message, array $context = []);
}