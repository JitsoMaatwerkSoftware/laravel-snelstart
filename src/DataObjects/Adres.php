<?php

namespace Jitso\LaravelSnelstart\DataObjects;

class Adres extends DataObject
{
    public function __construct(
        public readonly ?string $contactpersoon = null,
        public readonly ?string $straat = null,
        public readonly ?string $postcode = null,
        public readonly ?string $plaats = null,
        public readonly ?Identifier $land = null,
    ) {}

    protected static function mapConstructorArgs(array $data): array
    {
        return [
            'contactpersoon' => $data['contactpersoon'] ?? null,
            'straat' => $data['straat'] ?? null,
            'postcode' => $data['postcode'] ?? null,
            'plaats' => $data['plaats'] ?? null,
            'land' => isset($data['land']) ? Identifier::fromArray($data['land']) : null,
        ];
    }

    public function toArray(): array
    {
        return array_filter([
            'contactpersoon' => $this->contactpersoon,
            'straat' => $this->straat,
            'postcode' => $this->postcode,
            'plaats' => $this->plaats,
            'land' => $this->land?->toArray(),
        ], fn ($v) => $v !== null);
    }
}
