<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Model;

class Grootboek extends Model
{
    protected static bool $canCreate = true;

    protected static bool $canUpdate = false;

    protected static bool $canDelete = false;

    protected static bool $supportsOData = true;

    public static function endpoint(): string
    {
        return 'grootboeken';
    }
}
