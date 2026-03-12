<?php

namespace Jitso\LaravelSnelstart\Models;

use Illuminate\Support\Collection;
use Jitso\LaravelSnelstart\Concerns\CanCreate;
use Jitso\LaravelSnelstart\Concerns\CanDelete;
use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Concerns\CanUpdate;
use Jitso\LaravelSnelstart\Concerns\CanUpsert;
use Jitso\LaravelSnelstart\DataObjects\CustomField;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property array|null $relatiesoort
 * @property string|null $modifiedOn
 * @property int|null $relatiecode
 * @property string|null $naam
 * @property array|null $vestigingsAdres
 * @property array|null $correspondentieAdres
 * @property string|null $telefoon
 * @property string|null $mobieleTelefoon
 * @property string|null $email
 * @property string|null $btwNummer
 * @property float|null $factuurkorting
 * @property int|null $krediettermijn
 * @property bool|null $bankieren
 * @property bool|null $nonactief
 * @property float|null $kredietLimiet
 * @property string|null $memo
 * @property string|null $kvkNummer
 * @property string|null $oin
 * @property string|null $websiteUrl
 * @property string|null $aanmaningsoort
 * @property array|null $offerteEmailVersturen
 * @property array|null $bevestigingsEmailVersturen
 * @property array|null $factuurEmailVersturen
 * @property array|null $aanmaningEmailVersturen
 * @property array|null $offerteAanvraagEmailVersturen
 * @property array|null $bestellingEmailVersturen
 * @property bool|null $ublBestandAlsBijlage
 * @property string|null $iban
 * @property string|null $bic
 * @property string|null $incassoSoort
 * @property array|null $factuurRelatie
 * @property string|null $inkoopBoekingenUri
 * @property string|null $verkoopBoekingenUri
 * @property array|null $documents
 * @property string|null $uri
 * @property array|null $extraVeldenKlant
 */
class Relatie extends Model
{
    protected static array $fillable = [
        'relatiesoort',
        'naam',
        'vestigingsAdres',
        'correspondentieAdres',
        'telefoon',
        'mobieleTelefoon',
        'email',
        'btwNummer',
        'factuurkorting',
        'krediettermijn',
        'bankieren',
        'nonactief',
        'kredietLimiet',
        'memo',
        'kvkNummer',
        'oin',
        'websiteUrl',
        'aanmaningsoort',
        'offerteEmailVersturen',
        'bevestigingsEmailVersturen',
        'factuurEmailVersturen',
        'aanmaningEmailVersturen',
        'offerteAanvraagEmailVersturen',
        'bestellingEmailVersturen',
        'ublBestandAlsBijlage',
        'iban',
        'bic',
        'incassoSoort',
        'factuurRelatie',
        'documents',
    ];

    protected static array $required = [];

    use CanCreate;
    use CanDelete;
    use CanRead;
    use CanUpdate;
    use CanUpsert;

    protected static bool $supportsOData = true;

    public static function endpoint(): string
    {
        return 'relaties';
    }

    /** @return Collection<int, Inkoopboeking> */
    public function inkoopboekingen(): Collection
    {
        $data = static::resolveClient()->get(static::endpoint()."/{$this->getKey()}/inkoopboekingen");

        return collect($data)->map(fn (array $item) => (new Inkoopboeking)->fill($item)->syncOriginal()->setExists(true));
    }

    /** @return Collection<int, Verkoopboeking> */
    public function verkoopboekingen(): Collection
    {
        $data = static::resolveClient()->get(static::endpoint()."/{$this->getKey()}/verkoopboekingen");

        return collect($data)->map(fn (array $item) => (new Verkoopboeking)->fill($item)->syncOriginal()->setExists(true));
    }

    public function doorlopendeIncassomachtigingen(): Collection
    {
        $data = static::resolveClient()->get(static::endpoint()."/{$this->getKey()}/doorlopendeincassomachtigingen");

        return collect($data);
    }

    /** @return Collection<int, CustomField> */
    public function customFields(): Collection
    {
        $data = static::resolveClient()->get(static::endpoint()."/{$this->getKey()}/customFields");

        return collect(CustomField::collection(
            is_array($data) ? $data : [],
        ));
    }

    public function updateCustomFields(array $fields): array
    {
        return static::resolveClient()->put(
            static::endpoint()."/{$this->getKey()}/customFields",
            $fields,
        );
    }
}
