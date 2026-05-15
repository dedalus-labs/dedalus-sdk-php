<?php

declare(strict_types=1);

namespace DedalusSDK\Audio\Translations;

use DedalusSDK\Audio\Translations\TranslationNewResponse\CreateTranslationResponseJSON;
use DedalusSDK\Audio\Translations\TranslationNewResponse\CreateTranslationResponseVerboseJSON;
use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;

/**
 * Fields:  # noqa: D415.
 *
 * - language (required): str
 * - duration (required): float
 * - text (required): str
 * - segments (optional): list[TranscriptionSegment]
 *
 * @phpstan-import-type CreateTranslationResponseVerboseJSONShape from \DedalusSDK\Audio\Translations\TranslationNewResponse\CreateTranslationResponseVerboseJSON
 * @phpstan-import-type CreateTranslationResponseJSONShape from \DedalusSDK\Audio\Translations\TranslationNewResponse\CreateTranslationResponseJSON
 *
 * @phpstan-type TranslationNewResponseVariants = CreateTranslationResponseVerboseJSON|CreateTranslationResponseJSON
 * @phpstan-type TranslationNewResponseShape = TranslationNewResponseVariants|CreateTranslationResponseVerboseJSONShape|CreateTranslationResponseJSONShape
 */
final class TranslationNewResponse implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            CreateTranslationResponseVerboseJSON::class,
            CreateTranslationResponseJSON::class,
        ];
    }
}
