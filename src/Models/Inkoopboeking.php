<?php

namespace Jitso\LaravelSnelstart\Models;

use Jitso\LaravelSnelstart\Model;

class Inkoopboeking extends Model
{
    protected static bool $canCreate = true;

    protected static bool $canUpdate = true;

    protected static bool $canDelete = true;

    protected static bool $supportsOData = false;

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
}
