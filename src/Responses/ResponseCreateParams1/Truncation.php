<?php

declare(strict_types=1);

namespace DedalusSDK\Responses\ResponseCreateParams1;

/**
 * The truncation strategy to use for the model response.
 * - `auto`: If the input to this Response exceeds
 *   the model's context window size, the model will truncate the
 *   response to fit the context window by dropping items from the beginning of the conversation.
 * - `disabled` (default): If the input size will exceed the context window
 *   size for a model, the request will fail with a 400 error.
 */
enum Truncation: string
{
    case AUTO = 'auto';

    case DISABLED = 'disabled';
}
