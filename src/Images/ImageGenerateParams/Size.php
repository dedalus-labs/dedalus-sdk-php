<?php

declare(strict_types=1);

namespace DedalusSDK\Images\ImageGenerateParams;

/**
 * The size of the generated images. Must be one of `1024x1024`, `1536x1024` (landscape), `1024x1536` (portrait), or `auto` (default value) for `gpt-image-1`, one of `256x256`, `512x512`, or `1024x1024` for `dall-e-2`, and one of `1024x1024`, `1792x1024`, or `1024x1792` for `dall-e-3`.
 */
enum Size: string
{
    case _256X256 = '256x256';

    case _512X512 = '512x512';

    case _1024X1024 = '1024x1024';

    case _1536X1024 = '1536x1024';

    case _1024X1536 = '1024x1536';

    case _1792X1024 = '1792x1024';

    case _1024X1792 = '1024x1792';

    case AUTO = 'auto';
}
