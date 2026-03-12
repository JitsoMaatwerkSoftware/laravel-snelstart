<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

class ArtikelPrijsafspraak extends Model
{
    use CanRead;

    protected static bool $supportsOData = true;

    public static function endpoint(): string
    {
        return 'artikelen/prijsafspraken';
    }
}
