<?php

namespace App\Serialization;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PaginationNormalizer implements NormalizerInterface
{
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        $data = $object;
        $totalRecords = $context['totalRecords'] ?? 0;
        $page = $context['page'] ?? 1;
        $limit = $context['limit'] ?? 10;
        $totalPages = (int) ceil($totalRecords / $limit);

        return [
            'data' => $data,
            'totalRecords' => $totalRecords,
            'page' => $page,
            'limit' => $limit,
            'totalPages' => $totalPages,
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return isset($context['pagination']);
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            '*' => true
        ];
    }
}
