<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Yaml\Yaml;

class TaxService
{
    private ?array $patterns = [];
    private LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger,
    ) {
        $this->logger = $logger;
        $this->patterns = $this->loadTaxNumberPatterns();
    }

    private function loadTaxNumberPatterns(): ?array
    {
        $filePath = __DIR__ . '/../../config/tax_number_formats.yaml';

        if (!file_exists($filePath)) {
            $this->logger->info('Taxes are not specified');
        }

        $patterns = Yaml::parseFile($filePath);
        if (empty($this->patterns)) {
            $this->logger->info('Config taxes file is empty');
        }

        return $patterns;
    }

    public function validateTaxNumber(string $taxNumber): void
    {
        $countryCode = substr($taxNumber, 0, 2);

        if(empty($this->patterns)) {
            return;
        }

        if (!isset($this->patterns[$countryCode])) {
            throw new BadRequestHttpException("Unsupported country code: $countryCode");
        }

        $regex = '/^' . str_replace(
            ['X', 'Y'],
            ['[0-9]', '[A-Z]'],
            $this->patterns[$countryCode]
        ) . '$/';

        if (!preg_match($regex, $taxNumber)) {
            throw new BadRequestHttpException("Invalid tax number format for country: $countryCode");
        }
    }
}