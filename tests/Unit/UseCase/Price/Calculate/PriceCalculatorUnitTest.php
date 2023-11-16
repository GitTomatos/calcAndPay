<?php

declare(strict_types=1);

namespace App\Tests\Unit\UseCase\Price\Calculate;

use App\Domain\Entity\Country\Country;
use App\Domain\Entity\Coupon\Coupon;
use App\Domain\Entity\Coupon\Type\CouponTypeEnum;
use App\Domain\Entity\Product\Product;
use App\UseCase\Price\Calculate\PriceCalculator;
use App\UseCase\Price\Calculate\PriceCalculatorDto;
use App\UseCase\Price\CountryTax\Apply\PriceWithAppliedCountryTaxCalculator;
use App\UseCase\Price\Coupon\Apply\PriceWithAppliedCouponCalculator;
use PHPUnit\Framework\TestCase;

class PriceCalculatorUnitTest extends TestCase
{
    /**
     * Проверяем положительный кейс обработки высчитывания цены
     * С применением купона
     */
    public function testPositiveCaseWithCoupon(): void
    {
        $priceWithAppliedCouponCalculator = $this->createMock(PriceWithAppliedCouponCalculator::class);
        $priceWithAppliedCouponCalculator->method('__invoke')->willReturn(90.);

        $priceWithAppliedCountryTaxCalculator = $this->createMock(PriceWithAppliedCountryTaxCalculator::class);
        $priceWithAppliedCountryTaxCalculator->method('__invoke')->willReturn(108.);

        $priceCalculator = new PriceCalculator(
            priceWithAppliedCouponCalculator: $priceWithAppliedCouponCalculator,
            priceWithAppliedCountryTaxCalculator: $priceWithAppliedCountryTaxCalculator,
        );

        $product = $this->createMock(Product::class);
        $product->method('getPrice')->willReturn(100.0);

        $country = $this->createMock(Country::class);

        $coupon = $this->createMock(Coupon::class);

        $resultPrice = $priceCalculator->__invoke(
            new PriceCalculatorDto(
                product: $product,
                country: $country,
                coupon: $coupon,
            ),
        );

        $this->assertEquals(108., $resultPrice);
    }

    /**
     * Проверяем положительный кейс обработки высчитывания цены
     * Без применения купона
     */
    public function testPositiveCaseWithoutCoupon(): void
    {
        $priceWithAppliedCouponCalculator = $this->createMock(PriceWithAppliedCouponCalculator::class);
        $priceWithAppliedCouponCalculator->method('__invoke')->willReturn(90.);

        $priceWithAppliedCountryTaxCalculator = $this->createMock(PriceWithAppliedCountryTaxCalculator::class);
        $priceWithAppliedCountryTaxCalculator->method('__invoke')->willReturn(120.);

        $priceCalculator = new PriceCalculator(
            priceWithAppliedCouponCalculator: $priceWithAppliedCouponCalculator,
            priceWithAppliedCountryTaxCalculator: $priceWithAppliedCountryTaxCalculator,
        );

        $product = $this->createMock(Product::class);
        $product->method('getPrice')->willReturn(100.0);

        $country = $this->createMock(Country::class);

        $resultPrice = $priceCalculator->__invoke(
            new PriceCalculatorDto(
                product: $product,
                country: $country,
            ),
        );

        $this->assertEquals(120., $resultPrice);
    }

    /**
     * Проверяем положительный кейс обработки высчитывания цены
     * С применением купона
     * Используем реальные объекты сервисов, чтобы проверить функциональность
     */
    public function testPositiveCaseWithCouponNoMock(): void
    {
        $priceWithAppliedCouponCalculator = new PriceWithAppliedCouponCalculator();

        $priceWithAppliedCountryTaxCalculator = new PriceWithAppliedCountryTaxCalculator();

        $priceCalculator = new PriceCalculator(
            priceWithAppliedCouponCalculator: $priceWithAppliedCouponCalculator,
            priceWithAppliedCountryTaxCalculator: $priceWithAppliedCountryTaxCalculator,
        );

        $product = $this->createMock(Product::class);
        $product->method('getPrice')->willReturn(100.0);

        $country = $this->createMock(Country::class);
        $country->method('getTaxNumberTemplate')->willReturn('RUXXX');
        $country->method('getTaxPercentage')->willReturn(0.2);

        $coupon = $this->createMock(Coupon::class);
        $coupon->method('getDiscount')->willReturn(0.1);
        $coupon->method('getType')->willReturn(CouponTypeEnum::Percent);

        $resultPrice = $priceCalculator->__invoke(
            new PriceCalculatorDto(
                product: $product,
                country: $country,
                coupon: $coupon,
            ),
        );

        $this->assertEquals(108., $resultPrice);
    }

    /**
     * Проверяем положительный кейс обработки высчитывания цены
     * Без применения купона
     * Используем реальные объекты сервисов, чтобы проверить функциональность
     */
    public function testPositiveCaseWithoutCouponNoMock(): void
    {
        $priceWithAppliedCouponCalculator = new PriceWithAppliedCouponCalculator();

        $priceWithAppliedCountryTaxCalculator = new PriceWithAppliedCountryTaxCalculator();

        $priceCalculator = new PriceCalculator(
            priceWithAppliedCouponCalculator: $priceWithAppliedCouponCalculator,
            priceWithAppliedCountryTaxCalculator: $priceWithAppliedCountryTaxCalculator,
        );

        $product = $this->createMock(Product::class);
        $product->method('getPrice')->willReturn(100.0);

        $country = $this->createMock(Country::class);
        $country->method('getTaxNumberTemplate')->willReturn('RUXXX');
        $country->method('getTaxPercentage')->willReturn(0.2);

        $resultPrice = $priceCalculator->__invoke(
            new PriceCalculatorDto(
                product: $product,
                country: $country,
            ),
        );

        $this->assertEquals(120., $resultPrice);
    }
}