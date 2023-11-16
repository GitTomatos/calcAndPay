<?php

declare(strict_types=1);

namespace App\Domain\Entity\Coupon\Type;

enum CouponTypeEnum: int
{
    case FixAmount = 1;
    case Percent = 2;
}
