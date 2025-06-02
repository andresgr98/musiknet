<?php

namespace App\Track\Infrastructure;

use App\Track\Domain\TrackStorageRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Throwable;

class TrackServiceRepositoryImpl
{
    public function __construct(
        #[Autowire('%env(string:TRACK_SERVICE_URL)%')]
        private readonly string $url,
        #[Autowire('%env(string:TRACK_SERVICE_API_KEY)%')]
        private readonly string $apiKey
    ) {}

    public function create(UploadedFile $trackFile, string $uuid): void
    {
        $postFields = [
            'file' => new \CURLFile(
                $trackFile->getPathname(),
                $trackFile->getMimeType(),
                $trackFile->getClientOriginalName()
            )
        ];

        try {
            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL => $this->url . '/v1/tracks/' . $uuid,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'X-API-KEY: ' . $this->apiKey,
                    'Accept: application/json',
                ],
                CURLOPT_POSTFIELDS => $postFields,
            ]);

            $response = curl_exec($ch);

            if ($response === false) {
                throw new \RuntimeException('cURL error: ' . curl_error($ch));
            }

            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($statusCode >= 400) {
                throw new \RuntimeException("Request failed with status code $statusCode. Response: $response");
            }

            curl_close($ch);
        } catch (Throwable $e) {
            throw new \RuntimeException('TrackService upload failed: ' . $e->getMessage(), 0, $e);
        }
    }

    public function delete(string $name): void {}
}
