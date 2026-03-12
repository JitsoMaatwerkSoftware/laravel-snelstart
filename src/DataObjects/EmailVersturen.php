<?php

namespace Jitso\LaravelSnelstart\DataObjects;

class EmailVersturen extends DataObject
{
    public function __construct(
        public readonly ?bool $shouldSend = null,
        public readonly ?string $email = null,
        public readonly ?string $ccEmail = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'shouldSend' => $this->shouldSend,
            'email' => $this->email,
            'ccEmail' => $this->ccEmail,
        ], fn ($v) => $v !== null);
    }
}
