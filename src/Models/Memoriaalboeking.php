<?php

namespace Jitso\LaravelSnelstart\Models;

use Illuminate\Support\Collection;
use Jitso\LaravelSnelstart\Concerns\CanCreate;
use Jitso\LaravelSnelstart\Concerns\CanDelete;
use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Concerns\CanUpdate;
use Jitso\LaravelSnelstart\Concerns\CanUpsert;
use Jitso\LaravelSnelstart\DataObjects\BoekingVerantwoordingsRegel;
use Jitso\LaravelSnelstart\DataObjects\Identifier;
use Jitso\LaravelSnelstart\DataObjects\MemoriaalBoekingsRegel;
use Jitso\LaravelSnelstart\Enums\DocumentParentType;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property string|null $modifiedOn
 * @property string|null $datum
 * @property bool|null $markering
 * @property string|null $boekstuk
 * @property bool|null $gewijzigdDoorAccountant
 * @property string|null $omschrijving
 * @property \Illuminate\Support\Collection<int, MemoriaalBoekingsRegel>|null $memoriaalBoekingsRegels
 * @property \Illuminate\Support\Collection<int, BoekingVerantwoordingsRegel>|null $inkoopboekingBoekingsRegels
 * @property \Illuminate\Support\Collection<int, BoekingVerantwoordingsRegel>|null $verkoopboekingBoekingsRegels
 * @property Identifier|null $dagboek
 * @property string|null $uri
 */
class Memoriaalboeking extends Model
{
    use CanCreate;
    use CanDelete;
    use CanRead;
    use CanUpdate;
    use CanUpsert;

    protected static array $fillable = [
        'datum',
        'markering',
        'boekstuk',
        'omschrijving',
        'memoriaalBoekingsRegels',
        'inkoopboekingBoekingsRegels',
        'verkoopboekingBoekingsRegels',
        'dagboek',
    ];

    protected static array $required = [
        'datum',
        'dagboek',
    ];

    protected static array $casts = [
        'dagboek' => Identifier::class,
        'memoriaalBoekingsRegels' => [MemoriaalBoekingsRegel::class],
        'inkoopboekingBoekingsRegels' => [BoekingVerantwoordingsRegel::class],
        'verkoopboekingBoekingsRegels' => [BoekingVerantwoordingsRegel::class],
    ];

    public static function endpoint(): string
    {
        return 'memoriaalboekingen';
    }

    /** @return Collection<int, Document> */
    public function documentFiles(): Collection
    {
        $key = $this->getKey();
        if ($key === null) {
            return collect();
        }

        return Document::forParentType(DocumentParentType::Memoriaalboeking, $key);
    }
}
