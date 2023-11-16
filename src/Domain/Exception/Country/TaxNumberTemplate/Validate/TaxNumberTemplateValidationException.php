<?php

declare(strict_types=1);

namespace App\Domain\Exception\Country\TaxNumberTemplate\Validate;

use App\Domain\Exception\DomainException;

class TaxNumberTemplateValidationException extends DomainException
{
    public function __construct(string $taxNumberTemplate)
    {
        parent::__construct(message: "Некорректный шаблон налогового номера: $taxNumberTemplate");
    }
}