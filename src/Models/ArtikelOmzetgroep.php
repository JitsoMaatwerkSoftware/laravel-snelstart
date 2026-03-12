<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\DataObjects\Identifier;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property int|null $nummer
 * @property string|null $omschrijving
 * @property Identifier|null $verkoopGrootboekNederlandIdentifier
 * @property string|null $verkoopNederlandBtwSoort
 * @property string|null $uri
 */
class ArtikelOmzetgroep extends Model
{
    use CanRead;

    protected static array $casts = [
        'verkoopGrootboekNederlandIdentifier' => Identifier::class,
    ];

    public static function endpoint(): string
    {
        return 'artikelomzetgroepen';
    }
}
