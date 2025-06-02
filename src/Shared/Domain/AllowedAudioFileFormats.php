<?php

namespace App\Shared\Domain;

enum AllowedAudioFileFormats: string
{
    case MP3 = 'mp3';

    public static function isValidFormat(string $format): bool
    {
        return in_array($format, self::getValues(), true);
    }

    public static function getValues(): array
    {
        return array_map(fn(self $format) => $format->value, self::cases());
    }
}
