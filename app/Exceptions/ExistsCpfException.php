<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class ExistsCpfException extends Exception implements ExceptionInterface
{
    public function context(): array
    {
        return [
            'type' => 'ExistsCpfException',
            'message' => 'CPF exists in database.',
        ];
    }

    public function status(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}
