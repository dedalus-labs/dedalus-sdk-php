<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionUserMessageParam;

use DedalusSDK\Chat\Completions\ChatCompletionContentPartFileParam;
use DedalusSDK\Chat\Completions\ChatCompletionContentPartImageParam;
use DedalusSDK\Chat\Completions\ChatCompletionContentPartInputAudioParam;
use DedalusSDK\Chat\Completions\ChatCompletionContentPartTextParam;
use DedalusSDK\Chat\Completions\ChatCompletionUserMessageParam\Content\ChatCompletionRequestUserMessageContentArray;
use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\Core\Conversion\ListOf;

/**
 * The contents of the user message.
 *
 * @phpstan-import-type ChatCompletionRequestUserMessageContentArrayShape from \DedalusSDK\Chat\Completions\ChatCompletionUserMessageParam\Content\ChatCompletionRequestUserMessageContentArray
 *
 * @phpstan-type ContentVariants = string|list<ChatCompletionContentPartTextParam|ChatCompletionContentPartImageParam|ChatCompletionContentPartInputAudioParam|ChatCompletionContentPartFileParam>
 * @phpstan-type ContentShape = ContentVariants|list<ChatCompletionRequestUserMessageContentArrayShape>
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
            'string', new ListOf(ChatCompletionRequestUserMessageContentArray::class),
        ];
    }
}
