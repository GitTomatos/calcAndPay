<?php

declare(strict_types=1);

namespace App\System\Output\Error;

class ApiOutputError
{
    public function __construct(
        public string $message,
        public string $type,
        public int $code,
        public array $errors = [],
    ) {
    }
}