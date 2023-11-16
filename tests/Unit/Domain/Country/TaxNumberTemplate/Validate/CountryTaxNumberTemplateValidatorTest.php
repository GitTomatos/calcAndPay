<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Country\TaxNumberTemplate\Validate;

use App\Domain\Country\TaxNumberTemplate\Validate\CountryTaxNumberTemplateValidator;
use PHPUnit\Framework\TestCase;

class CountryTaxNumberTemplateValidatorTest extends TestCase
{
    public function testPositive1(): void
    {
        $countryTaxNumberTemplateValidator = new CountryTaxNumberTemplateValidator();
        $isValid = $countryTaxNumberTemplateValidator->__invoke('RUXXXXXXX');

        $this->assertTrue($isValid);
    }

    public function testPositive2(): void
    {
        $countryTaxNumberTemplateValidator = new CountryTaxNumberTemplateValidator();
        $isValid = $countryTaxNumberTemplateValidator->__invoke('RUXXXXXXYYX');

        $this->assertTrue($isValid);
    }

    public function testPositive3(): void
    {
        $countryTaxNumberTemplateValidator = new CountryTaxNumberTemplateValidator();
        $isValid = $countryTaxNumberTemplateValidator->__invoke('RUXXYXXXXYYX');

        $this->assertTrue($isValid);
    }

    public function testPositive4(): void
    {
        $countryTaxNumberTemplateValidator = new CountryTaxNumberTemplateValidator();
        $isValid = $countryTaxNumberTemplateValidator->__invoke('RXXXXXXX');

        $this->assertTrue($isValid);
    }

    public function testNegative1(): void
    {
        $countryTaxNumberTemplateValidator = new CountryTaxNumberTemplateValidator();
        $isValid = $countryTaxNumberTemplateValidator->__invoke('RUSSXXXXXXX');

        $this->assertFalse($isValid);
    }

    public function testNegative2(): void
    {
        $countryTaxNumberTemplateValidator = new CountryTaxNumberTemplateValidator();
        $isValid = $countryTaxNumberTemplateValidator->__invoke('R');

        $this->assertFalse($isValid);
    }

    public function testNegative3(): void
    {
        $countryTaxNumberTemplateValidator = new CountryTaxNumberTemplateValidator();
        $isValid = $countryTaxNumberTemplateValidator->__invoke('');

        $this->assertFalse($isValid);
    }

    public function testNegative4(): void
    {
        $countryTaxNumberTemplateValidator = new CountryTaxNumberTemplateValidator();
        $isValid = $countryTaxNumberTemplateValidator->__invoke('RU');

        $this->assertFalse($isValid);
    }

    public function testNegative5(): void
    {
        $countryTaxNumberTemplateValidator = new CountryTaxNumberTemplateValidator();
        $isValid = $countryTaxNumberTemplateValidator->__invoke('R2XXXXXXX');

        $this->assertFalse($isValid);
    }

    public function testNegative6(): void
    {
        $countryTaxNumberTemplateValidator = new CountryTaxNumberTemplateValidator();
        $isValid = $countryTaxNumberTemplateValidator->__invoke('RUXXX3XXX');

        $this->assertFalse($isValid);
    }
}