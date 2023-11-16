<?php

declare(strict_types=1);

namespace App\System\Fixtures;

use App\Domain\Entity\Product\Product;
use App\InfrastructureInterface\Persister\PersistenceManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function __construct(private PersistenceManagerInterface $persistenceManager)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createIphone();
        $this->createHeadphones();
        $this->createCase();
        $this->createVeryExpensiveProduct();

        $this->persistenceManager->flush();
    }

    private function createIphone(): void
    {
        $product = new Product(
            name: 'Iphone',
            price: 100,
        );

        $this->persistenceManager->persist($product);
    }

    private function createHeadphones(): void
    {
        $product = new Product(
            name: 'Наушники',
            price: 20,
        );

        $this->persistenceManager->persist($product);
    }

    private function createCase(): void
    {
        $product = new Product(
            name: 'Чехол',
            price: 10,
        );

        $this->persistenceManager->persist($product);
    }

    private function createVeryExpensiveProduct(): void
    {
        $product = new Product(
            name: 'Очень-очень дорогое золото',
            price: 1000000,
        );

        $this->persistenceManager->persist($product);
    }
}
