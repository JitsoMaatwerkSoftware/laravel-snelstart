<?php

namespace Jitso\LaravelSnelstart\DataObjects;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

abstract class DataObject implements Arrayable, JsonSerializable
{
    public static function fromArray(?array $data): ?static
    {
        if ($data === null) {
            return null;
        }

        return new static(...static::mapConstructorArgs($data));
    }

    /** @return static[] */
    public static function collection(?array $items): array
    {
        if ($items === null) {
            return [];
        }

        return array_map(fn (array $item) => static::fromArray($item), $items);
    }

    protected static function mapConstructorArgs(array $data): array
    {
        return $data;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
