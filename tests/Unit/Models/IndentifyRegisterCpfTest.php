<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\IndentifyRegisterCpf;
use Illuminate\Database\Eloquent\Builder;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * @internal
 */
class IndentifyRegisterCpfTest extends TestCase
{
    public function testValidateType()
    {
        $model = new IndentifyRegisterCpf();
        $this->assertSame(1, $model->getTypeIndentifyRegister());
    }

    public function testScopeFindCpf()
    {
        /** @var Builder $builder */
        $builder = $this->mock(Builder::class, function (MockInterface $mock) {
            $mock->shouldReceive('where')->once()->andReturnSelf();
        });
        $model = new IndentifyRegisterCpf();
        $this->assertInstanceOf(Builder::class, $model->scopeFindCpf($builder, null));
    }

    public function testVerifyAttributeCpf()
    {
        $model = new IndentifyRegisterCpf();
        $this->assertArrayHasKey('cpf', $model->toArray());
    }
}
