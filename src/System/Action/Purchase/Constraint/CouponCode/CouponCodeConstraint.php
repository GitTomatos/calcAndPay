<?php

declare(strict_types=1);

namespace App\System\Action\Purchase\Constraint\CouponCode;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class CouponCodeConstraint extends Constraint
{
    public function validatedBy(): string
    {
        return CouponCodeConstraintValidator::class;
    }
}