<?php

declare(strict_types=1);

namespace App\System\Fixtures;

use App\Domain\Entity\Country\Country;
use App\InfrastructureInterface\Persister\PersistenceManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends Fixture
{
    public const GERMANY = 'germany';
    public const ITALY = 'italy';
    public const FRANCE = 'france';
    public const GREECE = 'greece';

    public function __construct(private PersistenceManagerInterface $persistenceManager)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createGermany();
        $this->createItaly();
        $this->createFrance();
        $this->createGreece();

        $this->persistenceManager->flush();
    }

    private function createGermany(): void
    {
        $germany = new Country(
            name: 'Германия',
            taxNumberTemplate: 'DEXXXXXXXXX',
            taxPercentage: 0.19,
        );

        $this->persistenceManager->persist($germany);

        $this->addReference(self::GERMANY, $germany);
    }

    private function createItaly(): void
    {
        $italy = new Country(
            name: 'Италия',
            taxNumberTemplate: 'ITXXXXXXXXXXX',
            taxPercentage: 0.22,
        );

        $this->persistenceManager->persist($italy);

        $this->addReference(self::ITALY, $italy);
    }

    private function createFrance(): void
    {
        $france = new Country(
            name: 'Франция',
            taxNumberTemplate: 'FRYYXXXXXXXXX',
            taxPercentage: 0.20,
        );

        $this->persistenceManager->persist($france);

        $this->addReference(self::FRANCE, $france);
    }

    private function createGreece(): void
    {
        $greece = new Country(
            name: 'Греция',
            taxNumberTemplate: 'GRXXXXXXXXX',
            taxPercentage: 0.24,
        );

        $this->persistenceManager->persist($greece);

        $this->addReference(self::GREECE, $greece);
    }
}
