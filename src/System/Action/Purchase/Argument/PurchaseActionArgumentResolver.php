<?php

declare(strict_types=1);

namespace App\System\Action\Purchase\Argument;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class PurchaseActionArgumentResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (!$this->isAvailableType($argument)) {
            return [];
        }

        $product = $this->getProduct($request);
        $taxNumber = $this->getCountry($request);
        $couponCode = $this->getCoupon($request);
        $paymentProcessorEnum = $this->getPaymentProcessorEnum($request);

        return [
            new PurchaseActionArgument(
                productId: $product,
                taxNumber: $taxNumber,
                couponCode: $couponCode,
                paymentProcessor: $paymentProcessorEnum,
            ),
        ];
    }

    private function isAvailableType(ArgumentMetadata $argument): bool
    {
        $argumentType = $argument->getType();
        if (
            !$argumentType
            || $argumentType !== PurchaseActionArgument::class
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

    private function getPaymentProcessorEnum(Request $request): ?string
    {
        return $request->request->getString('paymentProcessor');
    }
}