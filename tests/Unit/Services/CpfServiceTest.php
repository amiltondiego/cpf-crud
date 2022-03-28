<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Exceptions\ExistsCpfException;
use App\Exceptions\InvalidCpfException;
use App\Exceptions\NotFoundCpfException;
use App\Models\IndentifyRegisterCpf;
use App\Services\CpfService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 */
class CpfServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testFindCpfSuccess()
    {
        $model = new IndentifyRegisterCpf();
        $model->indentify = 12345678901;
        $model->save();

        $service = new CpfService();

        $this->assertSame($model->toArray(), $service->findCPF('12345678901')->toArray());
    }

    public function testFindCpfNotFound()
    {
        $service = new CpfService();

        $this->expectException(NotFoundCpfException::class);
        $service->findCPF('12345678901');
    }

    public function testValidateCpfSuccess()
    {
        $service = new CpfService();

        $this->assertInstanceOf(CpfService::class, $service->validateCpf('81778954782'));
    }

    public function testValidateCpfNull()
    {
        $service = new CpfService();

        $this->expectException(InvalidCpfException::class);
        $service->validateCpf(null);
    }

    public function testValidateCpfLengthCpf()
    {
        $service = new CpfService();

        $this->expectException(InvalidCpfException::class);
        $service->validateCpf('123456789');
    }

    public function testValidateCpfSequenceCpf()
    {
        $service = new CpfService();

        $this->expectException(InvalidCpfException::class);
        $service->validateCpf('11111111111');
    }

    public function testValidateCpfNumberCpf()
    {
        $service = new CpfService();

        $this->expectException(InvalidCpfException::class);
        $service->validateCpf('12345678901');
    }

    public function testValidateClearCpf()
    {
        $service = new CpfService();
        $this->assertSame('12345678901', $service->clearCPF('123.456.789-01'));
    }

    public function testExistsCpfInDbSuccess()
    {
        $service = new CpfService();

        $this->assertInstanceOf(CpfService::class, $service->existsCpfInDB('81778954782'));
    }

    public function testExistsCpfInDbExceptionExists()
    {
        $model = new IndentifyRegisterCpf();
        $model->indentify = 81778954782;
        $model->save();

        $service = new CpfService();

        $this->expectException(ExistsCpfException::class);
        $service->existsCpfInDB('81778954782');
    }
}
