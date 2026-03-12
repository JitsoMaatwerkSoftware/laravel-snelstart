<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Model;

class Verkooporder extends Model
{
    protected static bool $canCreate = true;

    protected static bool $canUpdate = true;

    protected static bool $canDelete = true;

    protected static bool $supportsOData = true;

    public static function endpoint(): string
    {
        return 'verkooporders';
    }

    public function updateProcesStatus(string $status): array
    {
        return static::resolveClient()->put(
            static::endpoint()."/{$this->getKey()}/ProcesStatus",
            ['id' => $this->getKey(), 'procesStatus' => $status],
        );
    }
}
