<?php

namespace Jitso\LaravelSnelstart\Concerns;

use DateTimeImmutable;

trait HasTimestamps
{
    public function getModifiedOn(): ?DateTimeImmutable
    {
        $value = $this->getAttribute('modifiedOn');

        if ($value === null) {
            return null;
        }

        if ($value instanceof DateTimeImmutable) {
            return $value;
        }

        return new DateTimeImmutable($value);
    }
}
