<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers;

use App\Http\Controllers\CpfController;
use App\Services\CpfService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * @internal
 */
class CpfControllerTest extends TestCase
{
    public function testDestroyWithLogicException()
    {
        /** @var ResponseFactory $response */
        $response = $this->mock(ResponseFactory::class, function (MockInterface $mock) {
            $mock->shouldReceive('json')->once()->andReturn((new JsonResponse([], JsonResponse::HTTP_BAD_REQUEST)));
        });
        /** @var CpfService $service */
        $service = $this->mock(CpfService::class, function (MockInterface $mock) {
            $mock->shouldReceive('validateCpf')->once()->andReturnSelf();
        });

        $controller = new CpfController($service, $response);

        $this->assertSame(JsonResponse::HTTP_BAD_REQUEST, $controller->destroy('12345678901')->status());
    }
}
