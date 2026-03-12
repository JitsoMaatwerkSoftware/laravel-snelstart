<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $omschrijving
 * @property string|null $startdatum
 * @property string|null $einddatum
 * @property string|null $status
 * @property array|null $artikelPrijzen
 */
class Actieprijzen extends Model
{
    use CanRead;

    protected static bool $supportsOData = true;

    public static function endpoint(): string
    {
        return 'actieprijzen';
    }
}
