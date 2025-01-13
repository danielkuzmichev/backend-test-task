<?php

namespace App\Entity;

use App\Enum\DiscountTypeEnum;
use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50, unique: true)]
    private string $code;

    #[ORM\Column(type: 'string', enumType: DiscountTypeEnum::class)]
    private DiscountTypeEnum $discountType;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $discountValue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(DiscountTypeEnum $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getDiscountType(): DiscountTypeEnum
    {
        return $this->discountType;
    }

    public function setDiscountType(string $discountType): self
    {
        $this->discountType = $discountType;
        return $this;
    }

    public function getDiscountValue(): float
    {
        return $this->discountValue;
    }

    public function setDiscountValue(float $discountValue): self
    {
        $this->discountValue = $discountValue;
        return $this;
    }
}
