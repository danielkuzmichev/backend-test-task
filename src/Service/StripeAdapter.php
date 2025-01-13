<?php

namespace App\Service;

use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class StripeAdapter extends StripePaymentProcessor implements PaymentProcessorInterface
{
    public function execute(float $price): void
    {
        $this->processPayment($price);
    }
}