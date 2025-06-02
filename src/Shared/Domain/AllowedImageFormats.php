<?php

namespace App\Shared\Domain;

enum AllowedImageFormats: string
{
    case JPG = 'jpg';
    case JPEG = 'jpeg';
    case PNG = 'png';
    case WEBP = 'webp';

    public static function isValidFormat(string $format): bool
    {
        return in_array($format, self::getValues(), true);
    }

    public static function getValues(): array
    {
        return array_map(fn(self $format) => $format->value, self::cases());
    }
}
