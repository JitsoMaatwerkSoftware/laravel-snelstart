<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Model;

class Memoriaalboeking extends Model
{
    protected static bool $canCreate = true;

    protected static bool $canUpdate = true;

    protected static bool $canDelete = true;

    protected static bool $supportsOData = false;

    public static function endpoint(): string
    {
        return 'memoriaalboekingen';
    }
}
