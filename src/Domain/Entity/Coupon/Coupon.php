<?php

declare(strict_types=1);

namespace App\Domain\Entity\Coupon;

use App\Domain\Entity\Coupon\Type\CouponTypeEnum;
use App\InfrastructureImplementation\Repository\Coupon\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255)]
    private ?string $promocode = null;

    #[ORM\Column]
    private int $type;

    #[ORM\Column]
    private float $discount;

    public function __construct(
        string $name,
        string $promocode,
        CouponTypeEnum $type,
        float $discount,
    ) {
        $this->setName($name);
        $this->setPromocode($promocode);
        $this->setType($type);
        $this->setDiscount($discount);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPromocode(): ?string
    {
        return $this->promocode;
    }

    public function setPromocode(string $promocode): static
    {
        $this->promocode = $promocode;

        return $this;
    }

    public function getType(): CouponTypeEnum
    {
        return CouponTypeEnum::from($this->type);
    }

    public function setType(CouponTypeEnum $type): static
    {
        $this->type = $type->value;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): static
    {
        $this->discount = $discount;

        return $this;
    }
}
