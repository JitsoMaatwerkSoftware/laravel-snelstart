<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Model;

class CompanyInfo extends Model
{
    protected static bool $canCreate = false;

    protected static bool $canUpdate = true;

    protected static bool $canDelete = false;

    protected static bool $supportsOData = false;

    public static function endpoint(): string
    {
        return 'companyInfo';
    }

    public static function get(): static
    {
        $data = static::resolveClient()->get(static::endpoint());

        return (new static)->fill($data)->syncOriginal()->setExists(true);
    }

    public function update(array $attributes = []): static
    {
        $this->fill($attributes);
        $data = static::resolveClient()->put(static::endpoint(), $this->toArray());

        return $this->fill($data)->syncOriginal();
    }
}
