<?php

namespace Jitso\LaravelSnelstart\DataObjects;

class BoekingVerantwoordingsRegel extends DataObject
{
    public function __construct(
        public readonly ?Identifier $boekingId = null,
        public readonly ?string $omschrijving = null,
        public readonly ?float $debet = null,
        public readonly ?float $credit = null,
    ) {}

    protected static function mapConstructorArgs(array $data): array
    {
        return [
            'boekingId' => isset($data['boekingId']) ? Identifier::fromArray($data['boekingId']) : null,
            'omschrijving' => $data['omschrijving'] ?? null,
            'debet' => $data['debet'] ?? null,
            'credit' => $data['credit'] ?? null,
        ];
    }

    public function toArray(): array
    {
        return array_filter([
            'boekingId' => $this->boekingId?->toArray(),
            'omschrijving' => $this->omschrijving,
            'debet' => $this->debet,
            'credit' => $this->credit,
        ], fn ($v) => $v !== null);
    }
}
