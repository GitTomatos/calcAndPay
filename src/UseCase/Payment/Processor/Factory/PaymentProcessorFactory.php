<?php

declare(strict_types=1);

namespace App\UseCase\Payment\Processor\Factory;

use App\Domain\Payment\Processor\PaymentProcessorEnum;
use App\InfrastructureInterface\Payment\Processor\PaymentProcessorInterface;
use App\System\Payment\Processor\Adapter\PaypalPaymentProcessorAdapter;
use App\System\Payment\Processor\Adapter\StripePaymentProcessorAdapter;
use App\UseCase\Exception\Payment\Processor\Factory\PaymentProcessorFactoryException;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class PaymentProcessorFactory
{
    public function __construct(
        private readonly PaypalPaymentProcessor $paypalPaymentProcessor,
        private readonly StripePaymentProcessor $stripePaymentProcessor,
    ) {
    }

    /**
     * @param float $price - цена в крупных единицах
     * @throws PaymentProcessorFactoryException
     */
    public function __invoke(
        PaymentProcessorEnum $paymentProcessorEnum,
        float $price,
    ): PaymentProcessorInterface {
        return match ($paymentProcessorEnum) {
            PaymentProcessorEnum::Paypal => new PaypalPaymentProcessorAdapter(
                price: (int)($price * 100),
                paypalPaymentProcessor: $this->paypalPaymentProcessor
            ),
            PaymentProcessorEnum::Stripe => new StripePaymentProcessorAdapter(
                price: $price,
                stripePaymentProcessor: $this->stripePaymentProcessor
            ),
            default => throw new PaymentProcessorFactoryException(
                "Нет фабрики для процессора $paymentProcessorEnum->value"
            ),
        };
    }
}