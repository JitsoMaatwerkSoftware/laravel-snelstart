<?php

namespace Jitso\LaravelSnelstart\DataObjects;

class InkoopBoekingsRegel extends DataObject
{
    public function __construct(
        public readonly ?string $omschrijving = null,
        public readonly ?Identifier $grootboek = null,
        public readonly ?Identifier $kostenplaats = null,
        public readonly ?float $bedrag = null,
        public readonly ?string $btwSoort = null,
    ) {}

    protected static function mapConstructorArgs(array $data): array
    {
        return [
            'omschrijving' => $data['omschrijving'] ?? null,
            'grootboek' => isset($data['grootboek']) ? Identifier::fromArray($data['grootboek']) : null,
            'kostenplaats' => isset($data['kostenplaats']) ? Identifier::fromArray($data['kostenplaats']) : null,
            'bedrag' => $data['bedrag'] ?? null,
            'btwSoort' => $data['btwSoort'] ?? null,
        ];
    }

    public function toArray(): array
    {
        return array_filter([
            'omschrijving' => $this->omschrijving,
            'grootboek' => $this->grootboek?->toArray(),
            'kostenplaats' => $this->kostenplaats?->toArray(),
            'bedrag' => $this->bedrag,
            'btwSoort' => $this->btwSoort,
        ], fn ($v) => $v !== null);
    }
}
