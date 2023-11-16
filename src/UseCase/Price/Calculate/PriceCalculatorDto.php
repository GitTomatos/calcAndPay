<?php

declare(strict_types=1);

namespace App\UseCase\Price\Calculate;

use App\Domain\Entity\Country\Country;
use App\Domain\Entity\Coupon\Coupon;
use App\Domain\Entity\Product\Product;

class PriceCalculatorDto
{
    public function __construct(
        public Product $product,
        public Country $country,
        public ?Coupon $coupon = null,
    ) {
    }
}