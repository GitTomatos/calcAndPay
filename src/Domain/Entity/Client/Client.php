<?php

declare(strict_types=1);

namespace App\Domain\Entity\Client;

use App\Domain\Entity\Country\Country;
use App\InfrastructureImplementation\Repository\Client\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\ManyToOne(inversedBy: 'clients')]
    #[ORM\JoinColumn(nullable: false)]
    private Country $country;

    #[ORM\Column(options: ['default' => 0])]
    private float $sum;

    #[ORM\Column(length: 20)]
    private string $taxNumber;

    public function __construct(
        string $name,
        Country $country,
        float $sum,
        string $taxNumber,
    ) {
        $this->setName($name);
        $this->setCountry($country);
        $this->setSum($sum);
        $this->setTaxNumber($taxNumber);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function setCountry(Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getSum(): float
    {
        return $this->sum;
    }

    public function setSum(float $sum): static
    {
        $this->sum = $sum;

        return $this;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function setTaxNumber(string $taxNumber): static
    {
        $this->taxNumber = $taxNumber;

        return $this;
    }
}
