<?php

namespace Jitso\LaravelSnelstart\Models;

use Illuminate\Support\Collection;
use Jitso\LaravelSnelstart\Concerns\CanCreate;
use Jitso\LaravelSnelstart\Concerns\CanDelete;
use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Concerns\CanUpdate;
use Jitso\LaravelSnelstart\Concerns\CanUpsert;
use Jitso\LaravelSnelstart\DataObjects\Adres;
use Jitso\LaravelSnelstart\DataObjects\CustomField;
use Jitso\LaravelSnelstart\DataObjects\EmailVersturen;
use Jitso\LaravelSnelstart\DataObjects\ExtraVeld;
use Jitso\LaravelSnelstart\DataObjects\Identifier;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property string[]|null $relatiesoort
 * @property string|null $modifiedOn
 * @property int|null $relatiecode
 * @property string|null $naam
 * @property Adres|null $vestigingsAdres
 * @property Adres|null $correspondentieAdres
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
 * @property EmailVersturen|null $offerteEmailVersturen
 * @property EmailVersturen|null $bevestigingsEmailVersturen
 * @property EmailVersturen|null $factuurEmailVersturen
 * @property EmailVersturen|null $aanmaningEmailVersturen
 * @property EmailVersturen|null $offerteAanvraagEmailVersturen
 * @property EmailVersturen|null $bestellingEmailVersturen
 * @property bool|null $ublBestandAlsBijlage
 * @property string|null $iban
 * @property string|null $bic
 * @property string|null $incassoSoort
 * @property Identifier|null $factuurRelatie
 * @property string|null $inkoopBoekingenUri
 * @property string|null $verkoopBoekingenUri
 * @property \Illuminate\Support\Collection<int, Identifier>|null $documents
 * @property string|null $uri
 * @property \Illuminate\Support\Collection<int, ExtraVeld>|null $extraVeldenKlant
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

    protected static array $casts = [
        'vestigingsAdres' => Adres::class,
        'correspondentieAdres' => Adres::class,
        'offerteEmailVersturen' => EmailVersturen::class,
        'bevestigingsEmailVersturen' => EmailVersturen::class,
        'factuurEmailVersturen' => EmailVersturen::class,
        'aanmaningEmailVersturen' => EmailVersturen::class,
        'offerteAanvraagEmailVersturen' => EmailVersturen::class,
        'bestellingEmailVersturen' => EmailVersturen::class,
        'factuurRelatie' => Identifier::class,
        'documents' => [Identifier::class],
        'extraVeldenKlant' => [ExtraVeld::class],
    ];

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
