<?php

declare(strict_types=1);

namespace App\UseCase\Price\Calculate;

use App\UseCase\Price\CountryTax\Apply\PriceWithAppliedCountryTaxCalculator;
use App\UseCase\Price\Coupon\Apply\PriceWithAppliedCouponCalculator;

class PriceCalculator
{
    public function __construct(
        private readonly PriceWithAppliedCouponCalculator $priceWithAppliedCouponCalculator,
        private readonly PriceWithAppliedCountryTaxCalculator $priceWithAppliedCountryTaxCalculator,
    ) {
    }

    public function __invoke(
        PriceCalculatorDto $priceCalculatorDto,
    ): float {
        $price = $priceCalculatorDto->product->getPrice();
        $coupon = $priceCalculatorDto->coupon;

        if ($coupon) {
            $price = $this->priceWithAppliedCouponCalculator->__invoke(
                price: $price,
                coupon: $coupon,
            );
        }

        return $this->priceWithAppliedCountryTaxCalculator->__invoke(
            price: $price,
            countryTax: $priceCalculatorDto->country->getTaxPercentage(),
        );
    }
}