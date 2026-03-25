<?php

namespace Jitso\LaravelSnelstart\Models;

use Illuminate\Support\Collection;
use Jitso\LaravelSnelstart\Concerns\CanCreate;
use Jitso\LaravelSnelstart\Concerns\CanDelete;
use Jitso\LaravelSnelstart\Concerns\CanRead;
use Jitso\LaravelSnelstart\Concerns\CanUpdate;
use Jitso\LaravelSnelstart\Concerns\CanUpsert;
use Jitso\LaravelSnelstart\DataObjects\BtwBoeking;
use Jitso\LaravelSnelstart\DataObjects\Identifier;
use Jitso\LaravelSnelstart\DataObjects\InkoopBoekingsRegel;
use Jitso\LaravelSnelstart\Enums\DocumentParentType;
use Jitso\LaravelSnelstart\Model;

/**
 * @property string|null $id
 * @property string|null $modifiedOn
 * @property string|null $boekstuk
 * @property bool|null $gewijzigdDoorAccountant
 * @property bool|null $markering
 * @property string|null $factuurdatum
 * @property string|null $factuurnummer
 * @property Identifier|null $leverancier
 * @property string|null $omschrijving
 * @property float|null $factuurbedrag
 * @property \Illuminate\Support\Collection<int, InkoopBoekingsRegel>|null $boekingsregels
 * @property \Illuminate\Support\Collection<int, BtwBoeking>|null $btw
 * @property \Illuminate\Support\Collection<int, Identifier>|null $documents
 * @property string|null $uri
 */
class Inkoopboeking extends Model
{
    use CanCreate;
    use CanDelete;
    use CanRead;
    use CanUpdate;
    use CanUpsert;

    protected static array $fillable = [
        'factuurdatum',
        'factuurnummer',
        'leverancier',
        'omschrijving',
        'factuurbedrag',
        'boekingsregels',
        'btw',
        'documents',
        'markering',
        'boekstuk',
    ];

    protected static array $required = [
        'factuurdatum',
        'factuurnummer',
        'leverancier',
        'boekingsregels',
    ];

    protected static array $casts = [
        'leverancier' => Identifier::class,
        'boekingsregels' => [InkoopBoekingsRegel::class],
        'btw' => [BtwBoeking::class],
        'documents' => [Identifier::class],
    ];

    public static function endpoint(): string
    {
        return 'inkoopboekingen';
    }

    public static function createFromUbl(string $fileName, string $content, ?string $pdfContent = null): array
    {
        $data = [
            'fileName' => $fileName,
            'content' => $content,
        ];

        if ($pdfContent !== null) {
            $data['pdfContent'] = $pdfContent;
        }

        return static::resolveClient()->post(static::endpoint().'/ubl', $data);
    }

    public static function createFromAttachment(string $fileName, string $base64Content): array
    {
        return static::resolveClient()->post(static::endpoint().'/CreateFromAttachment', [
            'fileName' => $fileName,
            'content' => $base64Content,
        ]);
    }

    public static function getCreateFromAttachmentStatus(string $instanceId): array
    {
        return static::resolveClient()->get(
            static::endpoint().'/GetCreateFromAttachmentStatus',
            ['instanceId' => $instanceId],
        );
    }

    /**
     * Rows from the documenten API (not the {@see $documents} identifier list on the boeking).
     *
     * @return Collection<int, Document>
     */
    public function documentFiles(): Collection
    {
        $key = $this->getKey();
        if ($key === null) {
            return collect();
        }

        return Document::forParentType(DocumentParentType::InkoopBoeking, $key);
    }
}
