<?php

declare(strict_types=1);

namespace App\System\Payment\Processor\Adapter;

use App\InfrastructureInterface\Payment\Processor\PaymentProcessorInterface;
use App\UseCase\Exception\Payment\Processor\PaymentProcessorException;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class StripePaymentProcessorAdapter implements PaymentProcessorInterface
{
    /**
     * @param float $price - цена в крупных единицах
     * @param StripePaymentProcessor $stripePaymentProcessor
     */
    public function __construct(
        private readonly float $price,
        private readonly StripePaymentProcessor $stripePaymentProcessor,
    ) {
    }

    /**
     * @throws PaymentProcessorException
     */
    public function process(): void
    {
        $isSuccess = $this->stripePaymentProcessor->processPayment($this->price);

        if (!$isSuccess) {
            throw new PaymentProcessorException('Неудачная оплата');
        }
    }
}