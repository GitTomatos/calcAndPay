<?php

declare(strict_types=1);

namespace App\System\Action\CalculatePrice\Argument\Mapper;

use App\Domain\Entity\Country\Country;
use App\Domain\Entity\Coupon\Coupon;
use App\Domain\Entity\Product\Product;
use App\Domain\Payment\Processor\PaymentProcessorEnum;
use App\InfrastructureInterface\Repository\Coupon\CouponRepositoryInterface;
use App\InfrastructureInterface\Repository\Product\ProductRepositoryInterface;
use App\System\Action\CalculatePrice\Argument\CalculatePriceActionArgument;
use App\UseCase\Country\Get\ByTaxNumber\CountryByTaxNumberGetter;
use App\UseCase\Entity\Exception\Country\CountryNotFoundException;
use App\UseCase\Entity\Exception\Coupon\CouponNotFoundException;
use App\UseCase\Entity\Exception\PaymentProcessor\Type\InvalidPaymentProcessorTypeException;
use App\UseCase\Entity\Exception\Product\ProductNotFoundException;
use App\UseCase\Price\Calculate\PriceCalculatorDto;

class CalculatePriceActionArgumentToPriceCalculatorDtoMapper
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly CountryByTaxNumberGetter $countryByTaxNumberGetter,
        private readonly CouponRepositoryInterface $couponRepository,
    ) {
    }

    /**
     * @throws CouponNotFoundException
     * @throws ProductNotFoundException
     * @throws CountryNotFoundException
     */
    public function __invoke(CalculatePriceActionArgument $calculatePriceActionArgument): PriceCalculatorDto
    {
        return new PriceCalculatorDto(
            product: $this->getProduct($calculatePriceActionArgument->productId),
            country: $this->getCountry($calculatePriceActionArgument->taxNumber),
            coupon: $this->getCoupon($calculatePriceActionArgument->couponCode),
        );
    }

    /**
     * @throws ProductNotFoundException
     */
    private function getProduct(int $productId): Product
    {
        $product = $this->productRepository->getById($productId);

        if (!$product) {
            ProductNotFoundException::byId($productId);
        }

        return $product;
    }

    /**
     * @throws CountryNotFoundException
     */
    private function getCountry(string $taxNumber): Country
    {
        return $this->countryByTaxNumberGetter->__invoke($taxNumber);
    }

    /**
     * @throws CouponNotFoundException
     */
    private function getCoupon(?string $promocode): ?Coupon
    {
        if (!$promocode) {
            return null;
        }

        $coupon = $this->couponRepository->getByPromocode($promocode);

        if (!$coupon) {
            CouponNotFoundException::byPromocode($promocode);
        }

        return $coupon;
    }

    /**
     * @throws InvalidPaymentProcessorTypeException
     */
    private function getPaymentProcessorEnum(string $paymentProcessorType): PaymentProcessorEnum
    {
        $paymentProcessorEnum = PaymentProcessorEnum::tryFrom($paymentProcessorType);

        if (!$paymentProcessorEnum) {
            throw new InvalidPaymentProcessorTypeException(
                $paymentProcessorType
            );
        }

        return $paymentProcessorEnum;
    }
}