<?php

declare(strict_types=1);

namespace App\UseCase\Country\Get\ByTaxNumber;

use App\Domain\Entity\Country\Country;
use App\InfrastructureInterface\Repository\Country\CountryRepositoryInterface;
use App\UseCase\Entity\Exception\Country\CountryNotFoundException;

class CountryByTaxNumberGetter
{
    public function __construct(private readonly CountryRepositoryInterface $countryRepository)
    {
    }

    /**
     * @throws CountryNotFoundException
     */
    public function __invoke(string $taxNumber): Country
    {
        //TODO сделать валидацию на отсутствие нужного количества символов
        $countryCode = substr($taxNumber, 0, 2);

        $country = $this->countryRepository->getByCode($countryCode);

        if (!$country) {
            CountryNotFoundException::byTaxNumberCountryCode($countryCode);
        }

        return $country;
    }
}