<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class NotFoundCpfException extends Exception implements ExceptionInterface
{
    public function context(): array
    {
        return [
            'type' => 'NotFoundCpfException',
            'message' => 'CPF not found.',
        ];
    }

    public function status(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
