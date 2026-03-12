<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property string|null $omschrijving
 * @property string|null $soort
 * @property bool|null $nonactief
 * @property int|null $nummer
 * @property string|null $uri
 */
class Dagboek extends Model
{
    use CanRead;

    public static function endpoint(): string
    {
        return 'dagboeken';
    }
}
