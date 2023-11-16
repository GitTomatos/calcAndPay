<?php

declare(strict_types=1);

namespace App\System\Action\CalculatePrice\Argument;

use App\System\Action\ActionArgumentDtoInterface;
use App\System\Action\Purchase\Constraint\CouponCode\CouponCodeConstraint;
use App\System\Action\Purchase\Constraint\Product\ProductIdConstraint;
use App\System\Action\Purchase\Constraint\TaxNumber\TaxNumberConstraint;
use Symfony\Component\Validator\Constraints as Assert;

class CalculatePriceActionArgument implements ActionArgumentDtoInterface
{
    public function __construct(
        #[Assert\NotNull(message: 'Не должно быть пустым')]
        #[Assert\Type('integer')]
        #[ProductIdConstraint]
        public int $productId,

        #[Assert\NotBlank(message: 'Не должно быть пустым')]
        #[TaxNumberConstraint]
        public string $taxNumber,

        #[Assert\Type('string')]
        #[CouponCodeConstraint]
        public ?string $couponCode,
    ) {
    }
}