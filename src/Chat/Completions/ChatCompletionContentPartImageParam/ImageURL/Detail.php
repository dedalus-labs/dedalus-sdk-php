<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionContentPartImageParam\ImageURL;

/**
 * Specifies the detail level of the image. Learn more in the [Vision guide](/docs/guides/vision#low-or-high-fidelity-image-understanding).
 */
enum Detail: string
{
    case AUTO = 'auto';

    case LOW = 'low';

    case HIGH = 'high';
}
