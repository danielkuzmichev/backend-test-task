<?php

namespace App\Service;

class PaymentService
{
    public function __construct(
        private PaymentServiceFactory $paymentProcessor
    ) {}

    public function makePayment(float $payment, string $paymentProcessorName): void
    {
        $paymentProcessor = $this->paymentProcessor->createPaymentService($paymentProcessorName);
        $paymentProcessor->execute($payment);
    }
}