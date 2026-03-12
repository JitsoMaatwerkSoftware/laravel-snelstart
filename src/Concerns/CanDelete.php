<?php

namespace Jitso\LaravelSnelstart\Concerns;

trait CanDelete
{
    public function delete(): bool
    {
        static::resolveClient()->delete(static::endpoint()."/{$this->getKey()}");
        $this->exists = false;

        return true;
    }
}
