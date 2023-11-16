<?php

declare(strict_types=1);

namespace App\System\Fixtures;

use App\Domain\Entity\Coupon\Coupon;
use App\Domain\Entity\Coupon\Type\CouponTypeEnum;
use App\InfrastructureInterface\Persister\PersistenceManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CouponFixtures extends Fixture
{
    public function __construct(private PersistenceManagerInterface $persistenceManager)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createFixAmount();
        $this->createPercent();
        $this->createBigFixAmount();

        $this->persistenceManager->flush();
    }

    private function createFixAmount(): void
    {
        $coupon = new Coupon(
            name: 'Скидка на 5 евро',
            promocode: 'FAD5',
            type: CouponTypeEnum::FixAmount,
            discount: 5,
        );

        $this->persistenceManager->persist($coupon);
    }

    private function createPercent(): void
    {
        $coupon = new Coupon(
            name: 'Скидка 10%',
            promocode: 'PD10',
            type: CouponTypeEnum::Percent,
            discount: 0.1,
        );

        $this->persistenceManager->persist($coupon);
    }

    private function createBigFixAmount(): void
    {
        $coupon = new Coupon(
            name: 'Скидка на 100 евро',
            promocode: 'FAD100',
            type: CouponTypeEnum::FixAmount,
            discount: 100,
        );

        $this->persistenceManager->persist($coupon);
    }
}
