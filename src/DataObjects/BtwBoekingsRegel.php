<?php

namespace Jitso\LaravelSnelstart\DataObjects;

class BtwBoekingsRegel extends DataObject
{
    public function __construct(
        public readonly ?float $debet = null,
        public readonly ?float $credit = null,
        public readonly ?string $type = null,
        public readonly ?string $tarief = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'debet' => $this->debet,
            'credit' => $this->credit,
            'type' => $this->type,
            'tarief' => $this->tarief,
        ], fn ($v) => $v !== null);
    }
}
