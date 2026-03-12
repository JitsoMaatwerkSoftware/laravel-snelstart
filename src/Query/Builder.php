<?php

namespace Jitso\LaravelSnelstart\Query;

use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use Jitso\LaravelSnelstart\Model;

class Builder
{
    private const OPERATOR_MAP = [
        '=' => 'eq',
        '!=' => 'ne',
        '<>' => 'ne',
        '>' => 'gt',
        '>=' => 'ge',
        '<' => 'lt',
        '<=' => 'le',
    ];

    /** @var array<int, string> */
    protected array $filters = [];

    protected ?int $top = null;

    protected ?int $skipAmount = null;

    protected array $extraQuery = [];

    public function __construct(
        protected Model $model,
    ) {}

    public function where(string $field, mixed $operator = null, mixed $value = null): static
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $odataOperator = self::OPERATOR_MAP[$operator] ?? $operator;
        $formattedValue = $this->formatValue($value);

        $this->filters[] = "{$field} {$odataOperator} {$formattedValue}";

        return $this;
    }

    public function whereContains(string $field, string $value): static
    {
        $escaped = str_replace("'", "''", $value);
        $this->filters[] = "contains({$field}, '{$escaped}')";

        return $this;
    }

    public function whereStartsWith(string $field, string $value): static
    {
        $escaped = str_replace("'", "''", $value);
        $this->filters[] = "startswith({$field}, '{$escaped}')";

        return $this;
    }

    public function whereEndsWith(string $field, string $value): static
    {
        $escaped = str_replace("'", "''", $value);
        $this->filters[] = "endswith({$field}, '{$escaped}')";

        return $this;
    }

    public function filter(string $rawFilter): static
    {
        $this->filters[] = $rawFilter;

        return $this;
    }

    public function take(int $amount): static
    {
        $this->top = $amount;

        return $this;
    }

    public function limit(int $amount): static
    {
        return $this->take($amount);
    }

    public function skip(int $amount): static
    {
        $this->skipAmount = $amount;

        return $this;
    }

    public function offset(int $amount): static
    {
        return $this->skip($amount);
    }

    public function withQuery(string $key, mixed $value): static
    {
        $this->extraQuery[$key] = $value;

        return $this;
    }

    public function get(): Collection
    {
        $data = $this->model::resolveClient()->get(
            $this->model::endpoint(),
            $this->buildQuery(),
        );

        return collect($data)->map(fn (array $item) => $this->model->newInstance($item));
    }

    public function first(): ?Model
    {
        return $this->take(1)->get()->first();
    }

    public function paginate(int $perPage = 500): LazyCollection
    {
        return LazyCollection::make(function () use ($perPage) {
            $offset = 0;

            do {
                $results = $this->take($perPage)->skip($offset)->get();

                foreach ($results as $model) {
                    yield $model;
                }

                $offset += $perPage;
            } while ($results->count() === $perPage);
        });
    }

    public function firstOrCreate(array $extra = []): Model
    {
        $existing = $this->first();

        if ($existing !== null) {
            return $existing;
        }

        return $this->model::create(array_merge($this->extractSearchAttributes(), $extra));
    }

    public function firstOrNew(array $extra = []): Model
    {
        $existing = $this->first();

        if ($existing !== null) {
            return $existing;
        }

        return new ($this->model::class)(array_merge($this->extractSearchAttributes(), $extra));
    }

    public function updateOrCreate(array $update = []): Model
    {
        $existing = $this->first();

        if ($existing !== null) {
            return $existing->update($update);
        }

        return $this->model::create(array_merge($this->extractSearchAttributes(), $update));
    }

    public function count(): int
    {
        return $this->get()->count();
    }

    /**
     * Extracts key-value pairs from simple equality filters
     * for use in create/update fallbacks.
     */
    protected function extractSearchAttributes(): array
    {
        $attributes = [];

        foreach ($this->filters as $filter) {
            if (preg_match("/^(\w+)\s+eq\s+'([^']*)'$/", $filter, $matches)) {
                $attributes[$matches[1]] = str_replace("''", "'", $matches[2]);
            } elseif (preg_match('/^(\w+)\s+eq\s+(true|false|null|\d+(?:\.\d+)?)$/', $filter, $matches)) {
                $attributes[$matches[1]] = match ($matches[2]) {
                    'true' => true,
                    'false' => false,
                    'null' => null,
                    default => str_contains($matches[2], '.') ? (float) $matches[2] : (int) $matches[2],
                };
            }
        }

        return $attributes;
    }

    protected function buildQuery(): array
    {
        $query = $this->extraQuery;

        if (! empty($this->filters)) {
            $query['$filter'] = implode(' and ', $this->filters);
        }

        if ($this->top !== null) {
            $query['$top'] = $this->top;
        }

        if ($this->skipAmount !== null) {
            $query['$skip'] = $this->skipAmount;
        }

        return $query;
    }

    private function formatValue(mixed $value): string
    {
        if (is_string($value)) {
            $escaped = str_replace("'", "''", $value);

            return "'{$escaped}'";
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_null($value)) {
            return 'null';
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d\TH:i:s\Z');
        }

        return (string) $value;
    }
}
