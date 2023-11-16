<?php

namespace App\InfrastructureInterface\Persister;

interface PersistenceManagerInterface
{
    public function persist(object $object): void;

    public function flush(): void;
}