<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanCreate;
use Jitso\LaravelSnelstart\Concerns\CanDelete;
use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Concerns\CanUpdate;
use Jitso\LaravelSnelstart\Concerns\CanUpsert;
use Jitso\LaravelSnelstart\DataObjects\BtwBoeking;
use Jitso\LaravelSnelstart\DataObjects\Identifier;
use Jitso\LaravelSnelstart\DataObjects\VerkoopBoekingsRegel;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property string|null $modifiedOn
 * @property string|null $boekstuk
 * @property bool|null $gewijzigdDoorAccountant
 * @property bool|null $markering
 * @property string|null $factuurdatum
 * @property string|null $factuurnummer
 * @property Identifier|null $klant
 * @property string|null $omschrijving
 * @property float|null $factuurbedrag
 * @property int|null $betalingstermijn
 * @property array|null $eenmaligeIncassoMachtiging
 * @property array|null $doorlopendeIncassoMachtiging
 * @property \Illuminate\Support\Collection<int, VerkoopBoekingsRegel>|null $boekingsregels
 * @property \Illuminate\Support\Collection<int, BtwBoeking>|null $btw
 * @property \Illuminate\Support\Collection<int, Identifier>|null $documents
 * @property string|null $uri
 */
class Verkoopboeking extends Model
{
    use CanCreate;
    use CanDelete;
    use CanRead;
    use CanUpdate;
    use CanUpsert;

    protected static array $fillable = [
        'factuurdatum',
        'factuurnummer',
        'klant',
        'omschrijving',
        'factuurbedrag',
        'betalingstermijn',
        'eenmaligeIncassoMachtiging',
        'doorlopendeIncassoMachtiging',
        'boekingsregels',
        'btw',
        'documents',
        'markering',
        'boekstuk',
    ];

    protected static array $required = [
        'factuurnummer',
        'klant',
        'boekingsregels',
    ];

    protected static array $casts = [
        'klant' => Identifier::class,
        'boekingsregels' => [VerkoopBoekingsRegel::class],
        'btw' => [BtwBoeking::class],
        'documents' => [Identifier::class],
    ];

    protected static bool $supportsOData = true;

    public static function endpoint(): string
    {
        return 'verkoopboekingen';
    }
}
