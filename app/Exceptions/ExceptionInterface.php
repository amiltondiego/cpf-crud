<?php

declare(strict_types=1);

namespace App\Exceptions;

interface ExceptionInterface
{
    public function context(): array;

    public function status(): int;
}
