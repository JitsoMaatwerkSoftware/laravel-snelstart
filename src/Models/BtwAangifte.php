<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

class BtwAangifte extends Model
{
    use CanRead;

    protected static bool $supportsOData = true;

    public static function endpoint(): string
    {
        return 'btwaangiftes';
    }

    public function externAangeven(bool $isExternAangegeven = true): array
    {
        return static::resolveClient()->put(
            static::endpoint()."/{$this->getKey()}/externAangeven",
            ['isExternAangegeven' => $isExternAangegeven],
        );
    }
}
