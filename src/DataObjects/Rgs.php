<?php

namespace Jitso\LaravelSnelstart\DataObjects;

class Rgs extends DataObject
{
    public function __construct(
        public readonly ?string $versie = null,
        public readonly ?string $rgsCode = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'versie' => $this->versie,
            'rgsCode' => $this->rgsCode,
        ], fn ($v) => $v !== null);
    }
}
