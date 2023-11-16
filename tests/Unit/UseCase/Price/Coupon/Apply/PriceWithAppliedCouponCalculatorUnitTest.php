<?php

declare(strict_types=1);

namespace App\Tests\Unit\UseCase\Price\Coupon\Apply;

use App\Domain\Entity\Coupon\Coupon;
use App\Domain\Entity\Coupon\Type\CouponTypeEnum;
use App\UseCase\Price\Coupon\Apply\PriceWithAppliedCouponCalculator;
use PHPUnit\Framework\TestCase;

class PriceWithAppliedCouponCalculatorUnitTest extends TestCase
{
    /**
     * Проверяем применение купона с фиксированной скидкой
     */
    public function testFixAmount(): void
    {
        $priceWithAppliedCouponCalculator = new PriceWithAppliedCouponCalculator();

        $coupon = $this->createMock(Coupon::class);
        $coupon->method('getType')->willReturn(CouponTypeEnum::FixAmount);
        $coupon->method('getDiscount')->willReturn(5.);

        $priceWithCoupon = $priceWithAppliedCouponCalculator->__invoke(
            price: 100,
            coupon: $coupon,
        );

        $this->assertEquals(95., $priceWithCoupon);
    }

    /**
     * Проверяем применение купона с процентной скидкой
     */
    public function testPercent(): void
    {
        $priceWithAppliedCouponCalculator = new PriceWithAppliedCouponCalculator();

        $coupon = $this->createMock(Coupon::class);
        $coupon->method('getType')->willReturn(CouponTypeEnum::FixAmount);
        $coupon->method('getDiscount')->willReturn(5.);

        $priceWithCoupon = $priceWithAppliedCouponCalculator->__invoke(
            price: 100,
            coupon: $coupon,
        );

        $this->assertEquals(95., $priceWithCoupon);
    }

    /**
     * Проверяем применение купона с фиксированной скидкой
     * Скидка больше, чем сумма
     */
    public function testFixAmountDiscountMoreThanPrice(): void
    {
        $priceWithAppliedCouponCalculator = new PriceWithAppliedCouponCalculator();

        $coupon = $this->createMock(Coupon::class);
        $coupon->method('getType')->willReturn(CouponTypeEnum::FixAmount);
        $coupon->method('getDiscount')->willReturn(5.);

        $priceWithCoupon = $priceWithAppliedCouponCalculator->__invoke(
            price: 1,
            coupon: $coupon,
        );

        $this->assertEquals(-4., $priceWithCoupon);
    }

    /**
     * Проверяем применение купона с процентной скидкой
     * Скидка 100%
     */
    public function testAmountDiscountMoreThanPrice(): void
    {
        $priceWithAppliedCouponCalculator = new PriceWithAppliedCouponCalculator();

        $coupon = $this->createMock(Coupon::class);
        $coupon->method('getType')->willReturn(CouponTypeEnum::Percent);
        $coupon->method('getDiscount')->willReturn(1.);

        $priceWithCoupon = $priceWithAppliedCouponCalculator->__invoke(
            price: 10,
            coupon: $coupon,
        );

        $this->assertEquals(0, $priceWithCoupon);
    }
}