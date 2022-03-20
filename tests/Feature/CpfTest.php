<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

/**
 * @internal
 */
class CpfTest extends TestCase
{
    use RefreshDatabase;

    public function testPostCpfInvalidException(): void
    {
        $response = $this->post('/api/cpf', [
            'cpf' => '85858585858',
        ]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
        $response->assertJsonFragment([
            'type' => 'InvalidCpfException',
        ]);
    }

    public function testPostCpfExistsException(): void
    {
        $this->testPostCpfValid();
        $response = $this->post('/api/cpf', [
            'cpf' => 22463236574,
        ]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
        $response->assertJsonFragment([
            'type' => 'ExistsCpfException',
        ]);
    }

    public function testPostCpfValid(): void
    {
        $response = $this->post('/api/cpf', [
            'cpf' => 22463236574,
        ]);

        $response->assertStatus(JsonResponse::HTTP_CREATED);
        $response->assertJsonFragment([
            'cpf' => 22463236574,
        ]);
    }

    public function testGetCpfNotFoundException(): void
    {
        $response = $this->get(sprintf('/api/cpf/%s', 22463236574));

        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response->assertJsonFragment([
            'type' => 'NotFoundCpfException',
        ]);
    }

    public function testGetCpfInvalidException(): void
    {
        $response = $this->get(sprintf('/api/cpf/%s', 22463236572));

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
        $response->assertJsonFragment([
            'type' => 'InvalidCpfException',
        ]);
    }

    public function testGetCpfValid(): void
    {
        $this->testPostCpfValid();
        $response = $this->get(sprintf('/api/cpf/%s', 22463236574));

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertJsonFragment([
            'cpf' => 22463236574,
        ]);
    }

    public function testDeleteCpfInvalidException(): void
    {
        $response = $this->delete(sprintf('/api/cpf/%s', 22463236572));

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
        $response->assertJsonFragment([
            'type' => 'InvalidCpfException',
        ]);
    }

    public function testDeleteCpfNotFoundException(): void
    {
        $response = $this->delete(sprintf('/api/cpf/%s', 22463236574));

        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response->assertJsonFragment([
            'type' => 'NotFoundCpfException',
        ]);
    }

    public function testDeleteCpfValid(): void
    {
        $this->testPostCpfValid();
        $response = $this->delete(sprintf('/api/cpf/%s', 22463236574));

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertJsonCount(0);

        $this->testGetCpfNotFoundException();
    }

    public function testGetAllCpfWithData(): void
    {
        $this->testPostCpfValid();
        $response = $this->get('/api/cpf');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function testGetAllCpfWithEmptyData(): void
    {
        $response = $this->get('/api/cpf');

        $response->assertStatus(200);
        $response->assertJsonCount(0);
    }
}
