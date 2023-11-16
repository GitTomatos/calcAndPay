<?php

declare(strict_types=1);

namespace App\System\Action\Purchase\Constraint\TaxNumber;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class TaxNumberConstraint extends Constraint
{
    public function validatedBy(): string
    {
        return TaxNumberConstraintValidator::class;
    }
}