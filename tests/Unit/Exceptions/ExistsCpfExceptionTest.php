<?php

declare(strict_types=1);

namespace Tests\Unit\Exceptions;

use App\Exceptions\ExistsCpfException;
use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * @internal
 */
class ExistsCpfExceptionTest extends TestCase
{
    public function testValidateContext()
    {
        $exception = new ExistsCpfException();
        $this->assertArrayHasKey('type', $exception->context());
        $this->assertSame('ExistsCpfException', $exception->context()['type']);
        $this->assertArrayHasKey('message', $exception->context());
        $this->assertSame('CPF exists in database.', $exception->context()['message']);
        $this->assertCount(2, $exception->context());
    }

    public function testValidateStatus()
    {
        $exception = new ExistsCpfException();
        $this->assertSame(Response::HTTP_BAD_REQUEST, $exception->status());
    }
}
