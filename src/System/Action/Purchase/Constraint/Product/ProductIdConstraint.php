<?php

declare(strict_types=1);

namespace App\System\Action\Purchase\Constraint\Product;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class ProductIdConstraint extends Constraint
{
    public function validatedBy(): string
    {
        return ProductIdConstraintValidator::class;
    }
}