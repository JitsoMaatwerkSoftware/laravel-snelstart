<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanCreate;
use Jitso\LaravelSnelstart\Concerns\CanDelete;
use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Concerns\CanUpdate;
use Jitso\LaravelSnelstart\Concerns\CanUpsert;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property string|null $omschrijving
 * @property bool|null $nonactief
 * @property int|null $nummer
 * @property string|null $uri
 */
class Kostenplaats extends Model
{
    use CanCreate;
    use CanDelete;
    use CanRead;
    use CanUpdate;
    use CanUpsert;

    protected static array $fillable = [
        'omschrijving',
        'nonactief',
        'nummer',
    ];

    protected static array $required = [];

    public static function endpoint(): string
    {
        return 'kostenplaatsen';
    }
}
