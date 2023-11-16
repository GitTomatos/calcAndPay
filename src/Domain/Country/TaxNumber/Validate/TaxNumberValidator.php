<?php

declare(strict_types=1);

namespace App\Domain\Country\TaxNumber\Validate;

use App\Domain\Country\TaxNumberTemplate\RegExpTemplate\CountryTaxNumberRegExpTemplateGetter;
use App\Domain\Country\TaxNumberTemplate\Validate\CountryTaxNumberTemplateValidator;
use App\Domain\Exception\Country\TaxNumberTemplate\Validate\TaxNumberTemplateValidationException;

class TaxNumberValidator
{
    public function __construct(
        private readonly CountryTaxNumberTemplateValidator $countryTaxNumberTemplateValidator,
        private readonly CountryTaxNumberRegExpTemplateGetter $countryTaxNumberRegExpTemplateGetter,
    ) {
    }

    /**
     * @throws TaxNumberTemplateValidationException
     */
    public function __invoke(string $taxNumberTemplate, string $taxNumberToCheck): bool
    {
        if (!$this->countryTaxNumberTemplateValidator->__invoke($taxNumberTemplate)) {
            throw new TaxNumberTemplateValidationException($taxNumberTemplate);
        }

        $taxNumberRegExpTemplate = $this->countryTaxNumberRegExpTemplateGetter->__invoke($taxNumberTemplate);

        return (bool)preg_match($taxNumberRegExpTemplate, $taxNumberToCheck);
    }
}