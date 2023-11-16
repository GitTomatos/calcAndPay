<?php

declare(strict_types=1);

namespace App\UseCase\Entity\Exception\PaymentProcessor\Type;

use App\UseCase\Entity\Exception\UseCaseException;

class InvalidPaymentProcessorTypeException extends UseCaseException
{
    public function __construct(string $paymentProcessorType)
    {
        parent::__construct(message: "Неверное значение paymentProcessor '$paymentProcessorType'");
    }
}