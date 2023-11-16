<?php

declare(strict_types=1);

namespace App\Tests\Unit\UseCase\Price\CountryTax\Apply;

use App\UseCase\Price\CountryTax\Apply\PriceWithAppliedCountryTaxCalculator;
use PHPUnit\Framework\TestCase;

class PriceWithAppliedCountryTaxCalculatorTest extends TestCase
{
    /**
     * Проверяем, что ценра с налогом высчитывается нормально
     */
    public function test()
    {
        $priceWithAppliedCountryTaxCalculator = new PriceWithAppliedCountryTaxCalculator();

        $priceWithTax = $priceWithAppliedCountryTaxCalculator->__invoke(
            price: 100.0,
            countryTax: 0.1,
        );

        $this->assertEqualsWithDelta(110., $priceWithTax, 0.00001);
    }
}