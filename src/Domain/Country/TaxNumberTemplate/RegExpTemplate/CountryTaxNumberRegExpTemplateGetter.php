<?php

declare(strict_types=1);

namespace App\Domain\Country\TaxNumberTemplate\RegExpTemplate;

class CountryTaxNumberRegExpTemplateGetter
{
    public function __invoke(string $taxNumberTemplate): string
    {
        $taxNumberTemplate = substr($taxNumberTemplate, 2);
        $taxNumberRegExpTemplate = str_replace('X', '\d', $taxNumberTemplate);
        $taxNumberRegExpTemplate = str_replace('Y', '\p{L}', $taxNumberRegExpTemplate);

        return '/^\p{L}{2}' . $taxNumberRegExpTemplate . '$/u';
    }
}