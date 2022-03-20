<?php

declare(strict_types=1);

namespace App\Models;

interface IndentifyRegisterInterface
{
    public function getTypeIndentifyRegister(): int;

    public function getVisibleAttributes(): array;
}
