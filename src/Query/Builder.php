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

    public function count(): int
    {
        return $this->get()->count();
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
