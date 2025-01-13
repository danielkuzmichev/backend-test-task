<?php

namespace App\Service;

use InvalidArgumentException;

class PaymentServiceFactory
{
    public function createPaymentService($paymentSystem): PaymentProcessorInterface
    {
        switch ($paymentSystem) {
            case 'paypal':
                return new PaypalAdapter();
            case 'stripe':
                return new StripeAdapter();
            default:
                throw new InvalidArgumentException("Unknown payment system");
        }
    }
}
