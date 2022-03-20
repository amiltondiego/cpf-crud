<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class IndentifyRegister extends Model implements IndentifyRegisterInterface
{
    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $dateFormat = \DateTime::ISO8601;

    /**
     * @var array
     */
    protected $dates = ['created_at'];

    /**
     * @var string
     */
    protected $table = 'indentify_registers';

    /**
     * @var string[]
     */
    protected $fillable = [
        'created_at',
        'type',
    ];

    public function __construct()
    {
        $this->visible = $this->getVisibleAttributes();

        parent::__construct([
            'created_at' => now(),
            'type' => $this->getTypeIndentifyRegister(),
            ...$this->attributes,
        ]);
    }
}
