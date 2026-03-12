<?php

namespace Jitso\LaravelSnelstart\Models;

use Illuminate\Support\Collection;
use Jitso\LaravelSnelstart\DataObjects\CustomField;
use Jitso\LaravelSnelstart\Model;

class Relatie extends Model
{
    protected static bool $canCreate = true;

    protected static bool $canUpdate = true;

    protected static bool $canDelete = true;

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
