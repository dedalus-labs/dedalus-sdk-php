<?php

declare(strict_types=1);

namespace DedalusSDK\Images\CreateImageRequest;

/**
 * The quality of the image that will be generated.
 *
 * - `auto` (default value) will automatically select the best quality for the given model.
 * - `high`, `medium` and `low` are supported for `gpt-image-1`.
 * - `hd` and `standard` are supported for `dall-e-3`.
 * - `standard` is the only option for `dall-e-2`.
 */
enum Quality: string
{
    case AUTO = 'auto';

    case HIGH = 'high';

    case MEDIUM = 'medium';

    case LOW = 'low';

    case HD = 'hd';

    case STANDARD = 'standard';
}
