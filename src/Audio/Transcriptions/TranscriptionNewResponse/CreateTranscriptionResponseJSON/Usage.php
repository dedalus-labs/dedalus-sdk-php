<?php

declare(strict_types=1);

namespace DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON;

use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON\Usage\TranscriptTextUsageDuration;
use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON\Usage\TranscriptTextUsageTokens;
use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;

/**
 * Token usage statistics for the request.
 *
 * @phpstan-import-type TranscriptTextUsageTokensShape from \DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON\Usage\TranscriptTextUsageTokens
 * @phpstan-import-type TranscriptTextUsageDurationShape from \DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON\Usage\TranscriptTextUsageDuration
 *
 * @phpstan-type UsageVariants = TranscriptTextUsageTokens|TranscriptTextUsageDuration
 * @phpstan-type UsageShape = UsageVariants|TranscriptTextUsageTokensShape|TranscriptTextUsageDurationShape
 */
final class Usage implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'tokens' => TranscriptTextUsageTokens::class,
            'duration' => TranscriptTextUsageDuration::class,
        ];
    }
}
