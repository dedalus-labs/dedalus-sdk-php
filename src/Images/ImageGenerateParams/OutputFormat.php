<?php

declare(strict_types=1);

namespace DedalusSDK\Images\ImageGenerateParams;

/**
 * The format in which the generated images are returned. This parameter is only supported for `gpt-image-1`. Must be one of `png`, `jpeg`, or `webp`.
 */
enum OutputFormat: string
{
    case PNG = 'png';

    case JPEG = 'jpeg';

    case WEBP = 'webp';
}
