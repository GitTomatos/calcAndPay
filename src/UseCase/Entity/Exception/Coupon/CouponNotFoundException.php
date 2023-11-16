<?php

declare(strict_types=1);

namespace App\UseCase\Entity\Exception\Coupon;

use App\UseCase\Entity\Exception\EntityNotFoundExceptionInterface;
use App\UseCase\Entity\Exception\UseCaseException;

class CouponNotFoundException extends UseCaseException implements EntityNotFoundExceptionInterface
{
    /**
     * @throws CouponNotFoundException
     */
    public static function byPromocode(string $promocode): void
    {
        throw new static(
            "Не найден купон с промокодом $promocode"
        );
    }
}