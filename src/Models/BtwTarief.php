<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Model;

class BtwTarief extends Model
{
    protected static bool $canCreate = false;

    protected static bool $canUpdate = false;

    protected static bool $canDelete = false;

    protected static bool $supportsOData = false;

    public static function endpoint(): string
    {
        return 'btwtarieven';
    }
}
