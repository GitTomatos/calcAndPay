<?php

namespace App\Domain\Entity\Country\TaxNumberTemplate;

enum TaxNumberTemplateEnum: string
{
    case Germany = 'DEXXXXXXXXX';
    case Italy = 'ITXXXXXXXXXXX';
    case Greece = 'GRXXXXXXXXX';
    case France = 'FRYYXXXXXXXXX';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
