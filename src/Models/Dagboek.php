<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

class Dagboek extends Model
{
    use CanRead;

    public static function endpoint(): string
    {
        return 'dagboeken';
    }
}
