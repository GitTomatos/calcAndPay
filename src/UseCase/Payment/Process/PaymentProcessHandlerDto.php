<?php

declare(strict_types=1);

namespace App\UseCase\Payment\Process;

use App\Domain\Entity\Country\Country;
use App\Domain\Entity\Coupon\Coupon;
use App\Domain\Entity\Product\Product;
use App\Domain\Payment\Processor\PaymentProcessorEnum;

class PaymentProcessHandlerDto
{
    public function __construct(
        public Product $product,
        public Country $country,
        public PaymentProcessorEnum $paymentProcessorEnum,
        public ?Coupon $coupon = null,
    ) {
    }
}