<?php

declare(strict_types=1);

namespace App\System\Fixtures;

use App\Domain\Entity\Client\Client;
use App\Domain\Entity\Country\Country;
use App\InfrastructureInterface\Persister\PersistenceManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly PersistenceManagerInterface $persistenceManager)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createEduard();
        $this->createAnton();
        $this->createPavel();
        $this->createSemyon();

        $this->persistenceManager->flush();
    }

    private function createEduard(): void
    {
        /** @var Country $country */
        $country = $this->getReference(CountryFixtures::GERMANY);

        $client = new Client(
            name: 'Эдуард',
            country: $country,
            sum: 10000,
            taxNumber: 'DE123456789',
        );

        $this->persistenceManager->persist($client);
    }

    private function createAnton(): void
    {
        /** @var Country $country */
        $country = $this->getReference(CountryFixtures::ITALY);

        $client = new Client(
            name: 'Антон',
            country: $country,
            sum: 10000,
            taxNumber: 'IT12345678901',
        );

        $this->persistenceManager->persist($client);
    }

    private function createPavel(): void
    {
        /** @var Country $country */
        $country = $this->getReference(CountryFixtures::GREECE);

        $client = new Client(
            name: 'Павел',
            country: $country,
            sum: 10000,
            taxNumber: 'GR123456789',
        );

        $this->persistenceManager->persist($client);
    }

    private function createSemyon(): void
    {
        /** @var Country $country */
        $country = $this->getReference(CountryFixtures::FRANCE);

        $client = new Client(
            name: 'Семён',
            country: $country,
            sum: 10000,
            taxNumber: 'FRAN123456789',
        );

        $this->persistenceManager->persist($client);
    }


    public function getDependencies(): array
    {
        return [
            CountryFixtures::class,
        ];
    }
}
