<?php

declare(strict_types=1);

namespace App\System\Action\Purchase\Constraint\TaxNumber;

use App\Domain\Country\TaxNumber\Validate\TaxNumberValidator;
use App\Domain\Entity\Country\TaxNumberTemplate\TaxNumberTemplateEnum;
use Attribute;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

#[Attribute]
class TaxNumberConstraintValidator extends ConstraintValidator
{
    public function __construct(private readonly TaxNumberValidator $countryTaxNumberValidator)
    {
    }

    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof TaxNumberConstraint) {
            throw new UnexpectedTypeException($constraint, TaxNumberConstraint::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $taxNumberTemplateEnum = $this->getCountryTaxNumberTemplateEnum($value);

        if (!$taxNumberTemplateEnum) {
            $this->context
                ->buildViolation('Указан налоговый номер с неверным кодом страны')
                ->addViolation();
        }

        $isValid = $this->countryTaxNumberValidator->__invoke(
            taxNumberTemplate: $taxNumberTemplateEnum->value,
            taxNumberToCheck: $value,
        );

        if (!$isValid) {
            $this->context
                ->buildViolation('Указан невалидный налоговый номер')
                ->addViolation();
        }
    }

    private function getCountryTaxNumberTemplateEnum(string $taxNumber): ?TaxNumberTemplateEnum
    {
        $taxNumberCountryCode = substr($taxNumber, 0, 2);

        foreach (TaxNumberTemplateEnum::values() as $taxNumberTemplate) {
            if (substr($taxNumberTemplate, 0, 2) === $taxNumberCountryCode) {
                return TaxNumberTemplateEnum::from($taxNumberTemplate);
            }
        }

        return null;
    }
}