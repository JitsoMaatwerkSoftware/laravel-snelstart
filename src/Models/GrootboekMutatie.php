<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property array|null $grootboek
 * @property array|null $kostenplaats
 * @property string|null $datum
 * @property string|null $modifiedOn
 * @property array|null $dagboek
 * @property string|null $omschrijving
 * @property float|null $debet
 * @property float|null $credit
 * @property float|null $saldo
 * @property array|null $documents
 * @property string|null $boekstuk
 * @property string|null $factuurNummer
 * @property array|null $relatiePublicIdentifier
 * @property string|null $uri
 */
class GrootboekMutatie extends Model
{
    use CanRead;

    protected static bool $supportsOData = true;

    public static function endpoint(): string
    {
        return 'grootboekmutaties';
    }
}
