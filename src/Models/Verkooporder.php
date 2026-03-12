<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanCreate;
use Jitso\LaravelSnelstart\Concerns\CanDelete;
use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Concerns\CanUpdate;
use Jitso\LaravelSnelstart\Concerns\CanUpsert;
use Jitso\LaravelSnelstart\Model;

class Verkooporder extends Model
{
    use CanCreate;
    use CanDelete;
    use CanRead;
    use CanUpdate;
    use CanUpsert;

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
