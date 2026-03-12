<?php

namespace Jitso\LaravelSnelstart\DataObjects;

class ExtraVeld extends DataObject
{
    public function __construct(
        public readonly ?string $naam = null,
        public readonly ?string $waarde = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'naam' => $this->naam,
            'waarde' => $this->waarde,
        ], fn ($v) => $v !== null);
    }
}
