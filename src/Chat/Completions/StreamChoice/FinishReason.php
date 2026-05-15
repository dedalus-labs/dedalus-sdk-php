<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\StreamChoice;

/**
 * The reason the model stopped generating tokens. This will be `stop` if the model hit a natural stop point or a provided stop sequence,
 * `length` if the maximum number of tokens specified in the request was reached,
 * `content_filter` if content was omitted due to a flag from our content filters,
 * `tool_calls` if the model called a tool, or `function_call` (deprecated) if the model called a function.
 */
enum FinishReason: string
{
    case STOP = 'stop';

    case LENGTH = 'length';

    case TOOL_CALLS = 'tool_calls';

    case CONTENT_FILTER = 'content_filter';

    case FUNCTION_CALL = 'function_call';
}
