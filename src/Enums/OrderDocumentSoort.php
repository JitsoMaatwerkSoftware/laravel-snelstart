<?php

namespace Jitso\LaravelSnelstart\Enums;

/**
 * Typical SnelStart print / order document kinds (werkbon, pakbon, orderbevestiging).
 * Use the matching field name and shape from the official API when posting to
 * {@see \Jitso\LaravelSnelstart\Models\Document::createForType} — this enum only
 * centralizes common string values for IDE support.
 */
enum OrderDocumentSoort: string
{
    case Werkbon = 'Werkbon';
    case Pakbon = 'Pakbon';
    case Orderbevestiging = 'Orderbevestiging';
}
