<?php

namespace App\InfrastructureInterface\Payment\Processor;

use App\UseCase\Exception\Payment\Processor\PaymentProcessorException;

interface PaymentProcessorInterface
{
    /**
     * @throws PaymentProcessorException
     */
    public function process(): void;
}