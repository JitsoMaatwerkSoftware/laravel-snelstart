<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $administratieIdentifier
 * @property string|null $administratieNaam
 * @property string|null $bedrijfsnaam
 * @property string|null $contactpersoon
 * @property string|null $adres
 * @property string|null $postcode
 * @property string|null $plaats
 * @property string|null $telefoon
 * @property string|null $mobieleTelefoon
 * @property string|null $email
 * @property string|null $website
 * @property string|null $iban
 * @property string|null $bic
 * @property string|null $rechtsvorm
 * @property string|null $btwNummer
 * @property string|null $kvKNummer
 * @property int|null $huidigBoekjaar
 */
class CompanyInfo extends Model
{
    use CanRead;

    protected static array $fillable = [];

    protected static array $required = [];

    public static function endpoint(): string
    {
        return 'companyInfo';
    }

    public static function get(): static
    {
        $data = static::resolveClient()->get(static::endpoint());

        return (new static)->fill($data)->syncOriginal()->setExists(true);
    }

    public function update(array $attributes = []): static
    {
        $this->fill($attributes);
        $data = static::resolveClient()->put(static::endpoint(), $this->toArray());

        return $this->fill($data)->syncOriginal();
    }
}
