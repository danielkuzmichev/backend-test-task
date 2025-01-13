<?php

namespace App\DTO;

readonly class PurchaseDTO
{
    public function __construct(
        private int $product,
        private string $paymentProcessor,
        private ?string $taxNumber = null,
        private ?string $couponCode = null,
    ) {}

    public function getProduct(): int
    {
        return $this->product;
    }

    public function getTaxNumber(): ?string
    {
        return $this->taxNumber;
    }

    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }

    public function getPaymentProcessor(): string
    {
        return $this->paymentProcessor;
    }
}