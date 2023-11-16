<?php

declare(strict_types=1);

namespace App\UseCase\Entity\Exception\Product;

use App\UseCase\Entity\Exception\EntityNotFoundExceptionInterface;
use App\UseCase\Entity\Exception\UseCaseException;

class ProductNotFoundException extends UseCaseException implements EntityNotFoundExceptionInterface
{
    /**
     * @throws ProductNotFoundException
     */
    public static function byId(int $productId): void
    {
        throw new static(
            "Не найден товар с id == $productId"
        );
    }
}