<?php

declare(strict_types=1);

namespace DedalusSDK\Audio\Transcriptions;

use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON;
use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseVerboseJSON;
use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;

/**
 * Represents a verbose json transcription response returned by model, based on the provided input.
 *
 * Fields:
 *   - language (required): str
 *   - duration (required): float
 *   - text (required): str
 *   - words (optional): list[TranscriptionWord]
 *   - segments (optional): list[TranscriptionSegment]
 *   - usage (optional): TranscriptTextUsageDuration
 *
 * @phpstan-import-type CreateTranscriptionResponseVerboseJSONShape from \DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseVerboseJSON
 * @phpstan-import-type CreateTranscriptionResponseJSONShape from \DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON
 *
 * @phpstan-type TranscriptionNewResponseVariants = CreateTranscriptionResponseVerboseJSON|CreateTranscriptionResponseJSON
 * @phpstan-type TranscriptionNewResponseShape = TranscriptionNewResponseVariants|CreateTranscriptionResponseVerboseJSONShape|CreateTranscriptionResponseJSONShape
 */
final class TranscriptionNewResponse implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            CreateTranscriptionResponseVerboseJSON::class,
            CreateTranscriptionResponseJSON::class,
        ];
    }
}
