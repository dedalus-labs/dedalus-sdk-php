<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChoiceDeltaToolCall;

/**
 * The type of the tool. Currently, only `function` is supported.
 */
enum Type: string
{
    case FUNCTION = 'function';
}
