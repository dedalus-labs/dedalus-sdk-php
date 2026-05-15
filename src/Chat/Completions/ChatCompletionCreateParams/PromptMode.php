<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionCreateParams;

/**
 * Allows toggling between the reasoning mode and no system prompt. When set to `reasoning` the system prompt for reasoning models will be used.
 */
enum PromptMode: string
{
    case REASONING = 'reasoning';
}
