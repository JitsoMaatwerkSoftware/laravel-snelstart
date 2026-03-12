<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\DataObjects\ExtraVeld;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property string|null $omschrijving
 * @property bool|null $nonactief
 * @property bool|null $prijsIngaveExclusiefBtw
 * @property bool|null $nieuweOrdersBlokkeren
 * @property \Illuminate\Support\Collection<int, ExtraVeld>|null $extraHoofdVelden
 * @property \Illuminate\Support\Collection<int, ExtraVeld>|null $extraRegelVelden
 * @property string|null $uri
 */
class Verkoopordersjabloon extends Model
{
    use CanRead;

    protected static array $casts = [
        'extraHoofdVelden' => [ExtraVeld::class],
        'extraRegelVelden' => [ExtraVeld::class],
    ];

    public static function endpoint(): string
    {
        return 'verkoopordersjablonen';
    }
}
