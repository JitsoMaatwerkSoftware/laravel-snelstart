<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $btwSoort
 * @property float|null $btwPercentage
 * @property string|null $datumVanaf
 * @property string|null $datumTotEnMet
 */
class BtwTarief extends Model
{
    use CanRead;

    public static function endpoint(): string
    {
        return 'btwtarieven';
    }
}
