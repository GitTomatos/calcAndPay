<?php

declare(strict_types=1);

namespace App\UseCase\Payment\Process;

use App\UseCase\Exception\Payment\Processor\Factory\PaymentProcessorFactoryException;
use App\UseCase\Exception\Payment\Processor\PaymentProcessorException;
use App\UseCase\Payment\Processor\Factory\PaymentProcessorFactory;
use App\UseCase\Price\Calculate\PriceCalculator;
use App\UseCase\Price\Calculate\PriceCalculatorDto;

class PaymentProcessHandler
{
    public function __construct(
        private readonly PriceCalculator $priceCalculator,
        private readonly PaymentProcessorFactory $paymentProcessorFactory,
    ) {
    }

    /**
     * @throws PaymentProcessorFactoryException
     * @throws PaymentProcessorException
     */
    public function __invoke(
        PaymentProcessHandlerDto $paymentProcessHandlerDto,
    ): void {
        $calculatedPrice = $this->priceCalculator->__invoke(
            new PriceCalculatorDto(
                product: $paymentProcessHandlerDto->product,
                country: $paymentProcessHandlerDto->country,
                coupon: $paymentProcessHandlerDto->coupon,
            ),
        );

        $paymentProcessor = $this->paymentProcessorFactory->__invoke(
            paymentProcessorEnum: $paymentProcessHandlerDto->paymentProcessorEnum,
            price: $calculatedPrice,
        );

        $paymentProcessor->process();
    }
}