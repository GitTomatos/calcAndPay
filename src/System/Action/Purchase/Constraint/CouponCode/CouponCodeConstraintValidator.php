<?php

declare(strict_types=1);

namespace App\System\Action\Purchase\Constraint\CouponCode;

use App\InfrastructureInterface\Repository\Coupon\CouponRepositoryInterface;
use Attribute;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

#[Attribute]
class CouponCodeConstraintValidator extends ConstraintValidator
{
    public function __construct(private readonly CouponRepositoryInterface $couponRepository)
    {
    }

    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof CouponCodeConstraint) {
            throw new UnexpectedTypeException($constraint, CouponCodeConstraint::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!$this->couponRepository->getByPromocode($value)) {
            $this->context
                ->buildViolation("Нет купона с промокодом == $value")
                ->addViolation();
        }
    }
}