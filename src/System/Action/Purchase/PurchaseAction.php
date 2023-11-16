<?php

declare(strict_types=1);

namespace App\System\Action\Purchase;

use App\System\Action\JsonAbstractController;
use App\System\Action\Purchase\Argument\Mapper\PurchaseActionArgumentToPaymentProcessHandlerDto;
use App\System\Action\Purchase\Argument\PurchaseActionArgument;
use App\System\Output\Error\ApiOutputError;
use App\UseCase\Exception\Payment\Processor\PaymentProcessorException;
use App\UseCase\Payment\Process\PaymentProcessHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PurchaseAction extends JsonAbstractController
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly PaymentProcessHandler $paymentProcessHandler,
        private readonly PurchaseActionArgumentToPaymentProcessHandlerDto $purchaseActionArgumentToPaymentProcessHandlerDto,
    ) {
        parent::__construct(validator: $validator);
    }

    #[Route(path: '/purchase', name: 'purchaseAction', methods: ['POST'])]
    public function __invoke(PurchaseActionArgument $purchaseActionArgument): JsonResponse
    {
        $this->validateDto($purchaseActionArgument);

        try {
            $this->paymentProcessHandler->__invoke(
                $this->purchaseActionArgumentToPaymentProcessHandlerDto->__invoke($purchaseActionArgument),
            );
        } catch (PaymentProcessorException $e) {
            return $this->json(
                new ApiOutputError(
                    message: $e->getMessage(),
                    type: $e::class,
                    code: 400,
                ),
            );
        }

        return new JsonResponse();
    }
}