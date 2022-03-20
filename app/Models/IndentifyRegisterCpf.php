<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property int $indentify
 *
 * @method static Builder findCpf(?string $cpf)
 */
class IndentifyRegisterCpf extends IndentifyRegister
{
    /**
     * @var array
     */
    protected $appends = ['cpf'];

    public function getTypeIndentifyRegister(): int
    {
        return 1;
    }

    public function getVisibleAttributes(): array
    {
        return ['cpf', 'created_at'];
    }

    public function scopeFindCpf(Builder $query, ?string $cpf): Builder
    {
        return $query->where('indentify', $cpf);
    }

    protected function cpf(): Attribute
    {
        return new Attribute(
            get: fn () => $this->indentify,
        );
    }
}
