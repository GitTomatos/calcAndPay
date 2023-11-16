<?php

declare(strict_types=1);

namespace App\System\Action\CalculatePrice\Argument;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class CalculatePriceArgumentResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (!$this->isAvailableType($argument)) {
            return [];
        }

        $product = $this->getProduct($request);
        $taxNumber = $this->getCountry($request);
        $couponCode = $this->getCoupon($request);

        return [
            new CalculatePriceActionArgument(
                productId: $product,
                taxNumber: $taxNumber,
                couponCode: $couponCode,
            ),
        ];
    }

    private function isAvailableType(ArgumentMetadata $argument): bool
    {
        $argumentType = $argument->getType();
        if (
            !$argumentType
            || $argumentType !== CalculatePriceActionArgument::class
        ) {
            return false;
        }

        return true;
    }

    private function getProduct(Request $request): ?int
    {
        return $request->request->getInt('product');
    }

    private function getCountry(Request $request): ?string
    {
        return $request->request->getString('taxNumber');
    }

    private function getCoupon(Request $request): ?string
    {
        return $request->request->getString('couponCode');
    }
}