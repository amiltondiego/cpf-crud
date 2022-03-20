<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ExceptionInterface;
use App\Models\IndentifyRegisterCpf;
use App\Services\CpfService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CpfController extends Controller
{
    public function __construct(
        private CpfService $service,
        private ResponseFactory $response
    ) {
    }

    public function index(): JsonResponse
    {
        $allRegisters = IndentifyRegisterCpf::all()->toArray();

        return $this->response->json($allRegisters);
    }

    public function show(string $cpf): JsonResponse
    {
        try {
            $this->service->validateCpf($cpf);

            $findRegister = $this->service->findCPF($cpf);

            return $this->response->json($findRegister->toArray());
        } catch (ExceptionInterface $exception) {
            return $this->response->json($exception->context(), $exception->status());
        }
    }

    public function destroy(string $cpf): JsonResponse
    {
        try {
            $this->service->validateCpf($cpf)
                ->findCPF($cpf);

            return $this->response->json();
        } catch (ExceptionInterface $exception) {
            return $this->response->json($exception->context(), $exception->status());
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $cpf = is_string($request->get('cpf')) ? strval($request->get('cpf')) : null;
            $this->service->validateCpf($cpf)
                ->existsCpfInDB($cpf);

            $newRegister = new IndentifyRegisterCpf();
            $newRegister->indentify = intval($cpf);
            $newRegister->save();

            return $this->response->json($newRegister->toArray());
        } catch (ExceptionInterface $exception) {
            return $this->response->json($exception->context(), $exception->status());
        }
    }
}
