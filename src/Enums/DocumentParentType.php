<?php

namespace Jitso\LaravelSnelstart\Enums;

/**
 * Path segment for {@see \Jitso\LaravelSnelstart\Models\Document::forParent}:
 * GET documenten/{value}/{parentId}
 *
 * Confirm values against the Snelstart B2B API v2 documentation if a call fails.
 */
enum DocumentParentType: string
{
    case VerkoopBoeking = 'VerkoopBoeking';
    case InkoopBoeking = 'InkoopBoeking';
    case Verkooporder = 'Verkooporder';
    case Offerte = 'Offerte';
    case Relatie = 'Relatie';
    case Memoriaalboeking = 'Memoriaalboeking';
    case Bankboeking = 'Bankboeking';
    case Kasboeking = 'Kasboeking';
    case VerkoopFactuur = 'VerkoopFactuur';
}
