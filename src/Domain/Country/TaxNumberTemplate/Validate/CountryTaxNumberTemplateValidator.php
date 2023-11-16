<?php

declare(strict_types=1);

namespace App\Domain\Country\TaxNumberTemplate\Validate;

class CountryTaxNumberTemplateValidator
{
    public function __invoke(string $taxNumberTemplate): bool
    {
        if (!$this->isCountryCodeValid($taxNumberTemplate)) {
            return false;
        }

        $taxNumberTemplate = substr($taxNumberTemplate, 2);

        return (bool)preg_match('/^([XY])+$/', $taxNumberTemplate);
    }

    private function isCountryCodeValid(string $taxNumberTemplate): bool
    {
        $taxNumberTemplateCountryCode = substr($taxNumberTemplate, 0, 2);

        return (bool)preg_match('/^\p{L}{2}$/', $taxNumberTemplateCountryCode);
    }
}