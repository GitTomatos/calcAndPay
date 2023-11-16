<?php

namespace App\InfrastructureInterface\Repository\Country;

use App\Domain\Entity\Country\Country;

interface CountryRepositoryInterface
{
    public function getByCode(string $countryCode): ?Country;
}