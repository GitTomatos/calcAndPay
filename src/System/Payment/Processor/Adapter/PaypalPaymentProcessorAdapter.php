<?php

declare(strict_types=1);

namespace App\System\Payment\Processor\Adapter;

use App\InfrastructureInterface\Payment\Processor\PaymentProcessorInterface;
use App\UseCase\Exception\Payment\Processor\PaymentProcessorException;
use Exception;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

class PaypalPaymentProcessorAdapter implements PaymentProcessorInterface
{
    /**
     * @param int $price - цена в мелких единицах
     * @param PaypalPaymentProcessor $paypalPaymentProcessor
     */
    public function __construct(
        private readonly int $price,
        private readonly PaypalPaymentProcessor $paypalPaymentProcessor,
    ) {
    }

    /**
     * @throws PaymentProcessorException
     */
    public function process(): void
    {
        try {
            $this->paypalPaymentProcessor->pay($this->price);
        } catch (Exception $e) {
            throw new PaymentProcessorException($e->getMessage());
        }
    }
}