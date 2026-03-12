<?php

namespace Jitso\LaravelSnelstart\Concerns;

trait CanUpdate
{
    public function update(array $attributes = []): static
    {
        $this->fill($attributes);
        $data = static::resolveClient()->put(static::endpoint()."/{$this->getKey()}", $this->toArray());

        return $this->fill($data)->syncOriginal();
    }
}
