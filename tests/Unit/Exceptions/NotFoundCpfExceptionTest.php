<?php

declare(strict_types=1);

namespace Tests\Unit\Exceptions;

use App\Exceptions\NotFoundCpfException;
use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * @internal
 */
class NotFoundCpfExceptionTest extends TestCase
{
    public function testValidateContext()
    {
        $exception = new NotFoundCpfException();
        $this->assertArrayHasKey('type', $exception->context());
        $this->assertSame('NotFoundCpfException', $exception->context()['type']);
        $this->assertArrayHasKey('message', $exception->context());
        $this->assertSame('CPF not found.', $exception->context()['message']);
        $this->assertCount(2, $exception->context());
    }

    public function testValidateStatus()
    {
        $exception = new NotFoundCpfException();
        $this->assertSame(Response::HTTP_NOT_FOUND, $exception->status());
    }
}
