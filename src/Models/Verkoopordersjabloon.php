<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property string|null $omschrijving
 * @property bool|null $nonactief
 * @property bool|null $prijsIngaveExclusiefBtw
 * @property bool|null $nieuweOrdersBlokkeren
 * @property array|null $extraHoofdVelden
 * @property array|null $extraRegelVelden
 * @property string|null $uri
 */
class Verkoopordersjabloon extends Model
{
    use CanRead;

    public static function endpoint(): string
    {
        return 'verkoopordersjablonen';
    }
}
