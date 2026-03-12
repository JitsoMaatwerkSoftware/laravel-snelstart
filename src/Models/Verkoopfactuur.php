<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Model;

class Verkoopfactuur extends Model
{
    protected static bool $canCreate = false;

    protected static bool $canUpdate = false;

    protected static bool $canDelete = false;

    protected static bool $supportsOData = true;

    public static function endpoint(): string
    {
        return 'verkoopfacturen';
    }

    public function ubl(): array
    {
        return static::resolveClient()->get(static::endpoint()."/{$this->getKey()}/ubl");
    }
}
