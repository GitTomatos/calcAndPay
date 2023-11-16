<?php

declare(strict_types=1);

namespace App\System\Action\CalculatePrice;

use App\System\Action\CalculatePrice\Argument\CalculatePriceActionArgument;
use App\System\Action\CalculatePrice\Argument\Mapper\CalculatePriceActionArgumentToPriceCalculatorDtoMapper;
use App\System\Action\JsonAbstractController;
use App\UseCase\Price\Calculate\PriceCalculator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CalculatePriceAction extends JsonAbstractController
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly PriceCalculator $priceCalculator,
        private readonly CalculatePriceActionArgumentToPriceCalculatorDtoMapper $calculatePriceActionArgumentToPriceCalculatorDtoMapper,
    ) {
        parent::__construct(validator: $this->validator);
    }

    #[Route(path: '/calculate-price', name: 'calculatePriceAction', methods: ['POST'])]
    public function __invoke(CalculatePriceActionArgument $calculatePriceActionArgument): JsonResponse
    {
        $this->validateDto($calculatePriceActionArgument);

        $calculatedPrice = $this->priceCalculator->__invoke(
            $this->calculatePriceActionArgumentToPriceCalculatorDtoMapper->__invoke(
                $calculatePriceActionArgument,
            ),
        );

        return $this->json([
            'finalPrice' => $calculatedPrice,
        ]);
    }
}