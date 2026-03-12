<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

class Actieprijzen extends Model
{
    use CanRead;

    protected static bool $supportsOData = true;

    public static function endpoint(): string
    {
        return 'actieprijzen';
    }
}
