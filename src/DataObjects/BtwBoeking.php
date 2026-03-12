<?php

namespace Jitso\LaravelSnelstart\DataObjects;

class BtwBoeking extends DataObject
{
    public function __construct(
        public readonly ?string $btwSoort = null,
        public readonly ?float $btwBedrag = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'btwSoort' => $this->btwSoort,
            'btwBedrag' => $this->btwBedrag,
        ], fn ($v) => $v !== null);
    }
}
