<?php

namespace Jitso\LaravelSnelstart\DataObjects;

class Identifier extends DataObject
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $uri = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'uri' => $this->uri,
        ], fn ($v) => $v !== null);
    }
}
