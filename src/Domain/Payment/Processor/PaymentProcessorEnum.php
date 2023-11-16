<?php

namespace App\Domain\Payment\Processor;

enum PaymentProcessorEnum: string
{
    case Paypal = 'paypal';
    case Stripe = 'stripe';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
