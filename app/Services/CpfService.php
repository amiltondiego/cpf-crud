<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ExistsCpfException;
use App\Exceptions\InvalidCpfException;
use App\Exceptions\NotFoundCpfException;
use App\Models\IndentifyRegisterCpf;

class CpfService
{
    /**
     * @throws NotFoundCpfException
     */
    public function findCPF(?string $cpf): IndentifyRegisterCpf
    {
        $findRegister = IndentifyRegisterCpf::findCpf($cpf)->first();

        if (is_null($findRegister) || !$findRegister instanceof IndentifyRegisterCpf) {
            throw new NotFoundCpfException();
        }

        return $findRegister;
    }

    /**
     * @throws InvalidCpfException
     */
    public function validateCpf(?string $cpf): self
    {
        if (is_null($cpf)) {
            throw new InvalidCpfException();
        }

        $cpf = $this->clearCPF($cpf);

        $this->validateLengthCPF($cpf)
            ->validateSequenceCPF($cpf)
            ->validateNumberCPF($cpf);

        return $this;
    }

    public function clearCPF(string $cpf): string
    {
        return preg_replace('/[^0-9]/is', '', $cpf) ?? '';
    }

    /**
     * @throws ExistsCpfException
     */
    public function existsCpfInDB(?string $cpf): self
    {
        $findRegister = IndentifyRegisterCpf::findCpf($cpf)->first();

        if (!is_null($findRegister)) {
            throw new ExistsCpfException();
        }

        return $this;
    }

    /**
     * @throws InvalidCpfException
     */
    private function validateLengthCPF(string $cpf): self
    {
        if (11 !== strlen($cpf)) {
            throw new InvalidCpfException();
        }

        return $this;
    }

    /**
     * @throws InvalidCpfException
     */
    private function validateSequenceCPF(string $cpf): self
    {
        if (1 === preg_match('/(\d)\1{10}/', $cpf)) {
            throw new InvalidCpfException();
        }

        return $this;
    }

    /**
     * @throws InvalidCpfException
     */
    private function validateNumberCPF(string $cpf): self
    {
        for ($t = 9; $t < 11; ++$t) {
            $dr = 0;
            $cr = 0;
            for ($c = 0; $c < $t; ++$c) {
                $dr += intval($cpf[$c]) * (($t + 1) - $c);
                $cr = $c + 1;
            }
            $d = ((10 * $dr) % 11) % 10;
            if (intval($cpf[$cr]) !== $d) {
                throw new InvalidCpfException();
            }
        }

        return $this;
    }
}
