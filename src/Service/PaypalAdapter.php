<?php

namespace App\Service;

use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

class PaypalAdapter extends PaypalPaymentProcessor implements PaymentProcessorInterface
{
    public function execute(float $price): void
    {
        $price *= 100;
        $this->pay($price);
    }
}