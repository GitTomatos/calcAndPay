<?php

declare(strict_types=1);

namespace App\UseCase\Price\CountryTax\Apply;

class PriceWithAppliedCountryTaxCalculator
{
    public function __invoke(
        float $price,
        float $countryTax,
    ): float {
        return $price * (1 + $countryTax);
    }
}