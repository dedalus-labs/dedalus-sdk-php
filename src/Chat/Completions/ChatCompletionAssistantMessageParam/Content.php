<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionAssistantMessageParam;

use DedalusSDK\Chat\Completions\ChatCompletionAssistantMessageParam\Content\ChatCompletionRequestAssistantMessageContentArray;
use DedalusSDK\Chat\Completions\ChatCompletionContentPartRefusalParam;
use DedalusSDK\Chat\Completions\ChatCompletionContentPartTextParam;
use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\Core\Conversion\ListOf;

/**
 * The contents of the assistant message. Required unless `tool_calls` or `function_call` is specified.
 *
 * @phpstan-import-type ChatCompletionRequestAssistantMessageContentArrayShape from \DedalusSDK\Chat\Completions\ChatCompletionAssistantMessageParam\Content\ChatCompletionRequestAssistantMessageContentArray
 *
 * @phpstan-type ContentVariants = string|list<ChatCompletionContentPartTextParam|ChatCompletionContentPartRefusalParam>
 * @phpstan-type ContentShape = ContentVariants|list<ChatCompletionRequestAssistantMessageContentArrayShape>
 */
final class Content implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'string',
            new ListOf(ChatCompletionRequestAssistantMessageContentArray::class),
        ];
    }
}
