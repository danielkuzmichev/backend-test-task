<?php

namespace App\Service;

use App\Enum\DiscountTypeEnum;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Repository\TaxRateRepository;

class CalculationService
{
    private const MONEY_PRECISION = 2;
    private const PERCENT = 0.01;

    public function __construct(
        private ProductRepository $productRepository,
        private TaxRateRepository $taxRateRepository,
        private CouponRepository $couponRepository
    ) {}

    public function calculatePrice(int $productId, ?string $taxNumber = null, ?string $couponCode = null): float
    {
        $product = $this->productRepository->get($productId);
        $productPrice = 100.0;
        $taxPercent = 0.24;

        $resultPrice = $product->getPrice();

        if($couponCode !== null) {
            $this->applyCoupon($couponCode, $resultPrice);
        }

        if($taxPercent !== null) {
            $this->addTax($taxNumber, $resultPrice);
        }

        return $resultPrice;
    }

    public function applyCoupon(string $couponCode, float &$price): void
    {
        $coupon = $this->couponRepository->getByCode($couponCode);
        $type = $coupon->getDiscountType();
        $couponValue = $coupon->getDiscountValue();
        if($type->value === DiscountTypeEnum::FIXED) {
            $price -= $couponValue;
        } else {
            $price -= round($price * $couponValue * self::PERCENT, self::MONEY_PRECISION);
        }
    }

    public function addTax(string $taxNumber, float &$price)
    {
        $tax = $this->taxRateRepository->get($taxNumber);
        $taxPercent = $tax->getRate();
        $price += round($price * $taxPercent * self::PERCENT, self::MONEY_PRECISION);
    }
}