<?php

namespace Jitso\LaravelSnelstart\DataObjects;

class VerkooporderRegel extends DataObject
{
    public function __construct(
        public readonly ?Identifier $artikel = null,
        public readonly ?string $omschrijving = null,
        public readonly ?float $stuksprijs = null,
        public readonly ?float $aantal = null,
        public readonly ?float $kortingsPercentage = null,
        public readonly ?float $totaal = null,
    ) {}

    protected static function mapConstructorArgs(array $data): array
    {
        return [
            'artikel' => isset($data['artikel']) ? Identifier::fromArray($data['artikel']) : null,
            'omschrijving' => $data['omschrijving'] ?? null,
            'stuksprijs' => $data['stuksprijs'] ?? null,
            'aantal' => $data['aantal'] ?? null,
            'kortingsPercentage' => $data['kortingsPercentage'] ?? null,
            'totaal' => $data['totaal'] ?? null,
        ];
    }

    public function toArray(): array
    {
        return array_filter([
            'artikel' => $this->artikel?->toArray(),
            'omschrijving' => $this->omschrijving,
            'stuksprijs' => $this->stuksprijs,
            'aantal' => $this->aantal,
            'kortingsPercentage' => $this->kortingsPercentage,
            'totaal' => $this->totaal,
        ], fn ($v) => $v !== null);
    }
}
