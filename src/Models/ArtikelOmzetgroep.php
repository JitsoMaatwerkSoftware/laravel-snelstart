<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property int|null $nummer
 * @property string|null $omschrijving
 * @property array|null $verkoopGrootboekNederlandIdentifier
 * @property string|null $verkoopNederlandBtwSoort
 * @property string|null $uri
 */
class ArtikelOmzetgroep extends Model
{
    use CanRead;

    public static function endpoint(): string
    {
        return 'artikelomzetgroepen';
    }
}
