<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Country\TaxNumber\Validate;

use App\Domain\Country\TaxNumber\Validate\TaxNumberValidator;
use App\Domain\Country\TaxNumberTemplate\RegExpTemplate\CountryTaxNumberRegExpTemplateGetter;
use App\Domain\Country\TaxNumberTemplate\Validate\CountryTaxNumberTemplateValidator;
use App\Domain\Exception\Country\TaxNumberTemplate\Validate\TaxNumberTemplateValidationException;
use Symfony\Bundle\TwigBundle\Tests\TestCase;

class ClientTaxNumberValidatorTest extends TestCase
{
    public function testPositive1(): void
    {
        $taxNumberValidator = new TaxNumberValidator(
            countryTaxNumberTemplateValidator: new CountryTaxNumberTemplateValidator(),
            countryTaxNumberRegExpTemplateGetter: new CountryTaxNumberRegExpTemplateGetter(),
        );

        $isValid = $taxNumberValidator->__invoke(
            taxNumberTemplate: 'RUXX',
            taxNumberToCheck: 'RU12',
        );

        $this->assertTrue($isValid);
    }

    public function testPositive2(): void
    {
        $taxNumberValidator = new TaxNumberValidator(
            countryTaxNumberTemplateValidator: new CountryTaxNumberTemplateValidator(),
            countryTaxNumberRegExpTemplateGetter: new CountryTaxNumberRegExpTemplateGetter(),
        );

        $isValid = $taxNumberValidator->__invoke(
            taxNumberTemplate: 'RUXY',
            taxNumberToCheck: 'RU1A',
        );

        $this->assertTrue($isValid);
    }

    public function testPositive3(): void
    {
        $taxNumberValidator = new TaxNumberValidator(
            countryTaxNumberTemplateValidator: new CountryTaxNumberTemplateValidator(),
            countryTaxNumberRegExpTemplateGetter: new CountryTaxNumberRegExpTemplateGetter(),
        );

        $isValid = $taxNumberValidator->__invoke(
            taxNumberTemplate: 'RUY',
            taxNumberToCheck: 'RUЯ',
        );

        $this->assertTrue($isValid);
    }

    public function testNegative1(): void
    {
        $taxNumberValidator = new TaxNumberValidator(
            countryTaxNumberTemplateValidator: new CountryTaxNumberTemplateValidator(),
            countryTaxNumberRegExpTemplateGetter: new CountryTaxNumberRegExpTemplateGetter(),
        );

        $isValid = $taxNumberValidator->__invoke(
            taxNumberTemplate: 'RUX',
            taxNumberToCheck: 'RUA',
        );

        $this->assertFalse($isValid);
    }

    public function testNegative2(): void
    {
        $taxNumberValidator = new TaxNumberValidator(
            countryTaxNumberTemplateValidator: new CountryTaxNumberTemplateValidator(),
            countryTaxNumberRegExpTemplateGetter: new CountryTaxNumberRegExpTemplateGetter(),
        );

        $isValid = $taxNumberValidator->__invoke(
            taxNumberTemplate: 'RUY',
            taxNumberToCheck: 'RU1',
        );

        $this->assertFalse($isValid);
    }

    public function testNegative3(): void
    {
        $taxNumberValidator = new TaxNumberValidator(
            countryTaxNumberTemplateValidator: new CountryTaxNumberTemplateValidator(),
            countryTaxNumberRegExpTemplateGetter: new CountryTaxNumberRegExpTemplateGetter(),
        );

        $isValid = $taxNumberValidator->__invoke(
            taxNumberTemplate: 'RUXX',
            taxNumberToCheck: 'RU1',
        );

        $this->assertFalse($isValid);
    }

    public function testNegative4(): void
    {
        $taxNumberValidator = new TaxNumberValidator(
            countryTaxNumberTemplateValidator: new CountryTaxNumberTemplateValidator(),
            countryTaxNumberRegExpTemplateGetter: new CountryTaxNumberRegExpTemplateGetter(),
        );

        $isValid = $taxNumberValidator->__invoke(
            taxNumberTemplate: 'RUYY',
            taxNumberToCheck: 'RUA',
        );

        $this->assertFalse($isValid);
    }

    public function testNegativeWithException1(): void
    {
        $taxNumberValidator = new TaxNumberValidator(
            countryTaxNumberTemplateValidator: new CountryTaxNumberTemplateValidator(),
            countryTaxNumberRegExpTemplateGetter: new CountryTaxNumberRegExpTemplateGetter(),
        );

        $this->expectException(TaxNumberTemplateValidationException::class);

        $taxNumberValidator->__invoke(
            taxNumberTemplate: 'R',
            taxNumberToCheck: 'R',
        );
    }
}