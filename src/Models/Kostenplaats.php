<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanCreate;
use Jitso\LaravelSnelstart\Concerns\CanDelete;
use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Concerns\CanUpdate;
use Jitso\LaravelSnelstart\Concerns\CanUpsert;
use Jitso\LaravelSnelstart\Model;

class Kostenplaats extends Model
{
    use CanCreate;
    use CanDelete;
    use CanRead;
    use CanUpdate;
    use CanUpsert;

    public static function endpoint(): string
    {
        return 'kostenplaatsen';
    }
}
