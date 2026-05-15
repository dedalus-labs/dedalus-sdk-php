<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionUserMessageParam\Content;

use DedalusSDK\Chat\Completions\ChatCompletionContentPartFileParam;
use DedalusSDK\Chat\Completions\ChatCompletionContentPartImageParam;
use DedalusSDK\Chat\Completions\ChatCompletionContentPartInputAudioParam;
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
 * @phpstan-import-type ChatCompletionContentPartImageParamShape from \DedalusSDK\Chat\Completions\ChatCompletionContentPartImageParam
 * @phpstan-import-type ChatCompletionContentPartInputAudioParamShape from \DedalusSDK\Chat\Completions\ChatCompletionContentPartInputAudioParam
 * @phpstan-import-type ChatCompletionContentPartFileParamShape from \DedalusSDK\Chat\Completions\ChatCompletionContentPartFileParam
 *
 * @phpstan-type ChatCompletionRequestUserMessageContentArrayVariants = ChatCompletionContentPartTextParam|ChatCompletionContentPartImageParam|ChatCompletionContentPartInputAudioParam|ChatCompletionContentPartFileParam
 * @phpstan-type ChatCompletionRequestUserMessageContentArrayShape = ChatCompletionRequestUserMessageContentArrayVariants|ChatCompletionContentPartTextParamShape|ChatCompletionContentPartImageParamShape|ChatCompletionContentPartInputAudioParamShape|ChatCompletionContentPartFileParamShape
 */
final class ChatCompletionRequestUserMessageContentArray implements ConverterSource
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
            'image_url' => ChatCompletionContentPartImageParam::class,
            'input_audio' => ChatCompletionContentPartInputAudioParam::class,
            'file' => ChatCompletionContentPartFileParam::class,
        ];
    }
}
