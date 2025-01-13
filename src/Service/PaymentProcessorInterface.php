<?php

namespace App\Service;

interface PaymentProcessorInterface
{
    public function execute(float $price): void;
}