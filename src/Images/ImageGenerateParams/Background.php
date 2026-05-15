<?php

declare(strict_types=1);

namespace DedalusSDK\Images\ImageGenerateParams;

/**
 * Allows to set transparency for the background of the generated image(s).
 * This parameter is only supported for `gpt-image-1`. Must be one of
 * `transparent`, `opaque` or `auto` (default value). When `auto` is used, the
 * model will automatically determine the best background for the image.
 *
 * If `transparent`, the output format needs to support transparency, so it
 * should be set to either `png` (default value) or `webp`.
 */
enum Background: string
{
    case TRANSPARENT = 'transparent';

    case OPAQUE = 'opaque';

    case AUTO = 'auto';
}
