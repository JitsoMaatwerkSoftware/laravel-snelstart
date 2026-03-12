<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanCreate;
use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

class Grootboek extends Model
{
    use CanCreate;
    use CanRead;

    protected static bool $supportsOData = true;

    public static function endpoint(): string
    {
        return 'grootboeken';
    }
}
