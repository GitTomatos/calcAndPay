<?php

namespace App\InfrastructureInterface\Repository\Coupon;

use App\Domain\Entity\Coupon\Coupon;

interface CouponRepositoryInterface
{
    public function getByPromocode(string $promocode): ?Coupon;
}