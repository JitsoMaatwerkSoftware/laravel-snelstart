<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

class Verkoopfactuur extends Model
{
    use CanRead;

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
