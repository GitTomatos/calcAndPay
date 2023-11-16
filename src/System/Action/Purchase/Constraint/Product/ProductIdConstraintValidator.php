<?php

declare(strict_types=1);

namespace App\System\Action\Purchase\Constraint\Product;

use App\InfrastructureInterface\Repository\Product\ProductRepositoryInterface;
use Attribute;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

#[Attribute]
class ProductIdConstraintValidator extends ConstraintValidator
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }

    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof ProductIdConstraint) {
            throw new UnexpectedTypeException($constraint, ProductIdConstraint::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_int($value)) {
            throw new UnexpectedValueException($value, 'int');
        }

        if (!$this->productRepository->getById($value)) {
            $this->context
                ->buildViolation("Нет товара с id == $value")
                ->addViolation();
        }
    }
}