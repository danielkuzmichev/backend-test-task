<?php

namespace App\Controller;

use App\DTO\CalculatePriceDTO;
use App\DTO\PurchaseDTO;
use App\Service\CalculationService;
use App\Service\PaymentService;
use App\Service\TaxService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Attribute\Route;

class SaleController extends AbstractController
{
    public function __construct(
        private TaxService $taxService,
        private CalculationService $calculationService,
        private PaymentService $paymentService
    ) {}

    #[Route(path: '/calculate-price', methods:['POST'])]
    public function calculatePrice(#[MapRequestPayload] CalculatePriceDTO $DTO): JsonResponse
    {
        $DTO->getTaxNumber() !== null && $this->taxService->validateTaxNumber($DTO->getTaxNumber());
        $result = $this->calculationService->calculatePrice(
            $DTO->getProduct(),
            $DTO->getTaxNumber(),
            $DTO->getCouponCode(),
        );
        return $this->json(['price' => $result]);
    }

    #[Route(path: '/purchase', methods:['POST'])]
    public function purchase(#[MapRequestPayload] PurchaseDTO $DTO): JsonResponse
    {
        $DTO->getTaxNumber() !== null && $this->taxService->validateTaxNumber($DTO->getTaxNumber());
        $price = $this->calculationService->calculatePrice(
            $DTO->getProduct(),
            $DTO->getTaxNumber(),
            $DTO->getCouponCode(),
        );
        $paymentService = $DTO->getPaymentProcessor();
        try {
            $this->paymentService->makePayment($price, $paymentService);
        } catch (Exception) {
            throw new UnprocessableEntityHttpException;
        }
        
        return $this->json('OK');
    }
}