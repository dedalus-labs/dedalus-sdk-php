<?php

declare(strict_types=1);

namespace DedalusSDK\Images\ImageGenerateParams;

/**
 * The format in which generated images with `dall-e-2` and `dall-e-3` are returned. Must be one of `url` or `b64_json`. URLs are only valid for 60 minutes after the image has been generated. This parameter isn't supported for `gpt-image-1` which will always return base64-encoded images.
 */
enum ResponseFormat: string
{
    case URL = 'url';

    case B64_JSON = 'b64_json';
}
