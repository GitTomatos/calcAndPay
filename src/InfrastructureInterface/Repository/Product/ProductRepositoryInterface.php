<?php

namespace App\InfrastructureInterface\Repository\Product;

use App\Domain\Entity\Product\Product;

interface ProductRepositoryInterface
{
    public function getById(int $productId): ?Product;
}