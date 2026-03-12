<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property array|null $boekjaar
 * @property string|null $betalenVoor
 * @property string|null $aangiftePeriodeBeginDatum
 * @property string|null $btwAangiftePeriode
 * @property string|null $datumTijdBerekening
 * @property string|null $datumTijdVerzending
 * @property bool|null $isSuppletie
 * @property bool|null $isAangifteGeschat
 * @property float|null $btwPercentageHoog
 * @property float|null $btwPercentageLaag
 * @property float|null $btwPercentageOverig
 * @property string|null $betalingskenmerk
 * @property string|null $foutBericht
 * @property string|null $btwAangifteStatus
 * @property string|null $btwNummer
 * @property string|null $uri
 */
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
