<?php

declare(strict_types=1);

namespace App\InfrastructureImplementation\Persister;

use App\InfrastructureInterface\Persister\PersistenceManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

class PersistenceManager implements PersistenceManagerInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function persist(object $object): void
    {
        $this->entityManager->persist($object);
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}