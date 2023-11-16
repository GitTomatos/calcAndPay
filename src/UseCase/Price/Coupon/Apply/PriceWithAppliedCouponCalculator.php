<?php

declare(strict_types=1);

namespace App\UseCase\Price\Coupon\Apply;

use App\Domain\Entity\Coupon\Coupon;
use App\Domain\Entity\Coupon\Type\CouponTypeEnum;

class PriceWithAppliedCouponCalculator
{
    public function __invoke(
        float $price,
        Coupon $coupon,
    ): float {
        $priceWithAppliedCoupon = $coupon->getType() === CouponTypeEnum::FixAmount
            ? $price - $coupon->getDiscount()
            : $price * (1 - $coupon->getDiscount());

        //Вероятно, тут должна быть логика типа такой (для случая с фиксированной скидкой)
//        if ($priceWithAppliedCoupon < 0) {
//            $priceWithAppliedCoupon = 0;
//        }

        return $priceWithAppliedCoupon;
    }
}