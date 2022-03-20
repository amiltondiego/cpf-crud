<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class InvalidCpfException extends Exception implements ExceptionInterface
{
    public function context(): array
    {
        return [
            'type' => 'InvalidCpfException',
            'message' => 'CPF is not valid.',
        ];
    }

    public function status(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}
