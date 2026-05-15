<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\CompletionCreateParams\SafetySetting;

/**
 * Required. Controls the probability threshold at which harm is blocked.
 */
enum Threshold: string
{
    case HARM_BLOCK_THRESHOLD_UNSPECIFIED = 'HARM_BLOCK_THRESHOLD_UNSPECIFIED';

    case BLOCK_LOW_AND_ABOVE = 'BLOCK_LOW_AND_ABOVE';

    case BLOCK_MEDIUM_AND_ABOVE = 'BLOCK_MEDIUM_AND_ABOVE';

    case BLOCK_ONLY_HIGH = 'BLOCK_ONLY_HIGH';

    case BLOCK_NONE = 'BLOCK_NONE';

    case OFF = 'OFF';
}
