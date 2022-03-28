<?php

declare(strict_types=1);

namespace Tests\Unit\Exceptions;

use App\Exceptions\InvalidCpfException;
use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * @internal
 */
class InvalidCpfExceptionTest extends TestCase
{
    public function testValidateContext()
    {
        $exception = new InvalidCpfException();
        $this->assertArrayHasKey('type', $exception->context());
        $this->assertSame('InvalidCpfException', $exception->context()['type']);
        $this->assertArrayHasKey('message', $exception->context());
        $this->assertSame('CPF is not valid.', $exception->context()['message']);
        $this->assertCount(2, $exception->context());
    }

    public function testValidateStatus()
    {
        $exception = new InvalidCpfException();
        $this->assertSame(Response::HTTP_BAD_REQUEST, $exception->status());
    }
}
