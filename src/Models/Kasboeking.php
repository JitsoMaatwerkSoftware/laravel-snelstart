<?php

namespace Jitso\LaravelSnelstart\Models;

use Illuminate\Support\Collection;
use Jitso\LaravelSnelstart\Concerns\CanCreate;
use Jitso\LaravelSnelstart\Concerns\CanDelete;
use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Concerns\CanUpdate;
use Jitso\LaravelSnelstart\Concerns\CanUpsert;
use Jitso\LaravelSnelstart\DataObjects\BoekingVerantwoordingsRegel;
use Jitso\LaravelSnelstart\DataObjects\BtwBoekingsRegel;
use Jitso\LaravelSnelstart\DataObjects\GrootboekBoekingsRegel;
use Jitso\LaravelSnelstart\DataObjects\Identifier;
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
 * @property \Illuminate\Support\Collection<int, GrootboekBoekingsRegel>|null $grootboekBoekingsRegels
 * @property \Illuminate\Support\Collection<int, BoekingVerantwoordingsRegel>|null $inkoopboekingBoekingsRegels
 * @property \Illuminate\Support\Collection<int, BoekingVerantwoordingsRegel>|null $verkoopboekingBoekingsRegels
 * @property \Illuminate\Support\Collection<int, BtwBoekingsRegel>|null $btwBoekingsregels
 * @property float|null $bedragUitgegeven
 * @property float|null $bedragOntvangen
 * @property Identifier|null $dagboek
 * @property string|null $uri
 */
class Kasboeking extends Model
{
    protected static array $fillable = [
        'datum',
        'markering',
        'boekstuk',
        'omschrijving',
        'grootboekBoekingsRegels',
        'inkoopboekingBoekingsRegels',
        'verkoopboekingBoekingsRegels',
        'btwBoekingsregels',
        'bedragUitgegeven',
        'bedragOntvangen',
        'dagboek',
    ];

    protected static array $required = [
        'datum',
        'bedragUitgegeven',
        'bedragOntvangen',
        'dagboek',
    ];

    protected static array $casts = [
        'dagboek' => Identifier::class,
        'grootboekBoekingsRegels' => [GrootboekBoekingsRegel::class],
        'inkoopboekingBoekingsRegels' => [BoekingVerantwoordingsRegel::class],
        'verkoopboekingBoekingsRegels' => [BoekingVerantwoordingsRegel::class],
        'btwBoekingsregels' => [BtwBoekingsRegel::class],
    ];

    use CanCreate;
    use CanDelete;
    use CanRead;
    use CanUpdate;
    use CanUpsert;

    protected static bool $supportsOData = true;

    public static function endpoint(): string
    {
        return 'kasboekingen';
    }

    /** @return Collection<int, Document> */
    public function documentFiles(): Collection
    {
        $key = $this->getKey();
        if ($key === null) {
            return collect();
        }

        return Document::forParentType(DocumentParentType::Kasboeking, $key);
    }
}
