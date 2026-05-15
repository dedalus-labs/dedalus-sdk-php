<?php

declare(strict_types=1);

namespace DedalusSDK\Images\CreateImageRequest;

/**
 * The style of the generated images. This parameter is only supported for `dall-e-3`. Must be one of `vivid` or `natural`. Vivid causes the model to lean towards generating hyper-real and dramatic images. Natural causes the model to produce more natural, less hyper-real looking images.
 */
enum Style: string
{
    case VIVID = 'vivid';

    case NATURAL = 'natural';
}
