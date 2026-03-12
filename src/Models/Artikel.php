<?php

namespace Jitso\LaravelSnelstart\Models;

use Illuminate\Support\Collection;
use Jitso\LaravelSnelstart\DataObjects\CustomField;
use Jitso\LaravelSnelstart\Model;
use Jitso\LaravelSnelstart\Query\Builder;

class Artikel extends Model
{
    protected static bool $canCreate = true;

    protected static bool $canUpdate = true;

    protected static bool $canDelete = true;

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
