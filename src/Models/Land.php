<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property string|null $naam
 * @property string|null $landcodeISO
 * @property string|null $landcode
 * @property string|null $uri
 */
class Land extends Model
{
    use CanRead;

    public static function endpoint(): string
    {
        return 'landen';
    }
}
