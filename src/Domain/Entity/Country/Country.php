<?php

declare(strict_types=1);

namespace App\Domain\Entity\Country;

use App\Domain\Entity\Client\Client;
use App\InfrastructureImplementation\Repository\Country\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(name: 'tax_number', length: 20)]
    private string $taxNumberTemplate;

    #[ORM\Column(name: 'tax_percentage')]
    private float $taxPercentage;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Client::class)]
    private Collection $clients;

    public function __construct(
        string $name,
        string $taxNumberTemplate,
        float $taxPercentage,
    ) {
        $this->setName($name);
        $this->setTaxNumberTemplate($taxNumberTemplate);
        $this->setTaxPercentage($taxPercentage);

        $this->clients = new ArrayCollection();
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

    public function getTaxNumberTemplate(): string
    {
        return $this->taxNumberTemplate;
    }

    public function setTaxNumberTemplate(string $taxNumberTemplate): static
    {
        $this->taxNumberTemplate = $taxNumberTemplate;

        return $this;
    }

    public function getTaxPercentage(): float
    {
        return $this->taxPercentage;
    }

    public function setTaxPercentage(float $taxPercentage): static
    {
        $this->taxPercentage = $taxPercentage;

        return $this;
    }

    /**
     * @return Collection<int, Client>
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): static
    {
        if (!$this->clients->contains($client)) {
            $this->clients->add($client);
            $client->setCountry($this);
        }

        return $this;
    }
}
