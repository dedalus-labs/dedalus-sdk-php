<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionAssistantMessageParam\Content;

use DedalusSDK\Chat\Completions\ChatCompletionContentPartRefusalParam;
use DedalusSDK\Chat\Completions\ChatCompletionContentPartTextParam;
use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;

/**
 * Learn about [text inputs](/docs/guides/text-generation).
 *
 * Fields:
 * - type (required): Literal["text"]
 * - text (required): str
 *
 * @phpstan-import-type ChatCompletionContentPartTextParamShape from \DedalusSDK\Chat\Completions\ChatCompletionContentPartTextParam
 * @phpstan-import-type ChatCompletionContentPartRefusalParamShape from \DedalusSDK\Chat\Completions\ChatCompletionContentPartRefusalParam
 *
 * @phpstan-type ChatCompletionRequestAssistantMessageContentArrayVariants = ChatCompletionContentPartTextParam|ChatCompletionContentPartRefusalParam
 * @phpstan-type ChatCompletionRequestAssistantMessageContentArrayShape = ChatCompletionRequestAssistantMessageContentArrayVariants|ChatCompletionContentPartTextParamShape|ChatCompletionContentPartRefusalParamShape
 */
final class ChatCompletionRequestAssistantMessageContentArray implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'text' => ChatCompletionContentPartTextParam::class,
            'refusal' => ChatCompletionContentPartRefusalParam::class,
        ];
    }
}
