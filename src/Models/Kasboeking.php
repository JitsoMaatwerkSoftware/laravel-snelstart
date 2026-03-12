<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Model;

class Kasboeking extends Model
{
    protected static bool $canCreate = true;

    protected static bool $canUpdate = true;

    protected static bool $canDelete = true;

    protected static bool $supportsOData = true;

    public static function endpoint(): string
    {
        return 'kasboekingen';
    }
}
