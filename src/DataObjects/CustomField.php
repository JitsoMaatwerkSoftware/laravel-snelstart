<?php

namespace Jitso\LaravelSnelstart\DataObjects;

class CustomField extends DataObject
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly mixed $value = null,
        public readonly ?array $definition = null,
    ) {}

    protected static function mapConstructorArgs(array $data): array
    {
        return [
            'name' => $data['name'] ?? $data['definition']['name'] ?? null,
            'value' => $data['value'] ?? null,
            'definition' => $data['definition'] ?? null,
        ];
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'value' => $this->value,
            'definition' => $this->definition,
        ], fn ($v) => $v !== null);
    }
}
