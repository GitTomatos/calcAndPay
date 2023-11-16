<?php

declare(strict_types=1);

namespace App\UseCase\Entity\Exception\Country;

use App\UseCase\Entity\Exception\EntityNotFoundExceptionInterface;
use App\UseCase\Entity\Exception\UseCaseException;

class CountryNotFoundException extends UseCaseException implements EntityNotFoundExceptionInterface
{
    /**
     * @throws CountryNotFoundException
     */
    public static function byTaxNumberCountryCode(string $countryCode): void
    {
        throw new static(
            "Не найдена страна по коду страны налогового номера. Передан код страны '$countryCode'"
        );
    }
}