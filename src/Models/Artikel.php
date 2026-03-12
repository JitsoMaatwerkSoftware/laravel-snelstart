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
use Jitso\LaravelSnelstart\Query\Builder;

/**
 * @property string|null $id
 * @property string|null $artikelcode
 * @property string|null $omschrijving
 * @property array|null $artikelOmzetgroep
 * @property float|null $verkoopprijs
 * @property float|null $inkoopprijs
 * @property string|null $eenheid
 * @property string|null $modifiedOn
 * @property array|null $relatie
 * @property bool|null $isNonActief
 * @property bool|null $voorraadControle
 * @property float|null $technischeVoorraad
 * @property float|null $vrijeVoorraad
 * @property array|null $extraVelden
 * @property string|null $uri
 */
class Artikel extends Model
{
    protected static array $fillable = [
        'artikelcode',
        'omschrijving',
        'artikelOmzetgroep',
        'verkoopprijs',
        'inkoopprijs',
        'eenheid',
        'relatie',
        'isNonActief',
        'voorraadControle',
        'extraVelden',
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
        return 'artikelen';
    }

    /** @return Collection<int, CustomField> */
    public function customFields(): Collection
    {
        $data = static::resolveClient()->get(static::endpoint()."/{$this->getKey()}/customFields");

        return collect(CustomField::collection($data));
    }

    public function updateCustomFields(array $fields): array
    {
        return static::resolveClient()->put(
            static::endpoint()."/{$this->getKey()}/customFields",
            $fields,
        );
    }

    public static function prijsafsprakenQuery(): Builder
    {
        return new Builder(new ArtikelPrijsafspraak);
    }

    public static function prijsafspraken(): Collection
    {
        return static::prijsafsprakenQuery()->get();
    }
}
