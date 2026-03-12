<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

/**
 * @property array|null $relatie
 * @property array|null $artikel
 * @property string|null $datum
 * @property float|null $aantal
 * @property float|null $korting
 * @property float|null $verkoopprijs
 * @property float|null $basisprijs
 * @property string|null $datumVanaf
 * @property string|null $datumTotEnMet
 * @property string|null $prijsBepalingSoort
 */
class Prijsafspraak extends Model
{
    use CanRead;

    protected static bool $supportsOData = true;

    public static function endpoint(): string
    {
        return 'prijsafspraken';
    }
}
