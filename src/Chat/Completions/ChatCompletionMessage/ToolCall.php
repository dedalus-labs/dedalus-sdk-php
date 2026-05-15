<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionMessage;

use DedalusSDK\Chat\Completions\ChatCompletionMessageCustomToolCall;
use DedalusSDK\Chat\Completions\ChatCompletionMessageToolCall;
use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;

/**
 * A call to a function tool created by the model.
 *
 * Fields:
 * - id (required): str
 * - type (required): Literal["function"]
 * - function (required): ChatCompletionMessageToolCallFunction
 * - thought_signature (optional): str
 *
 * @phpstan-import-type ChatCompletionMessageToolCallShape from \DedalusSDK\Chat\Completions\ChatCompletionMessageToolCall
 * @phpstan-import-type ChatCompletionMessageCustomToolCallShape from \DedalusSDK\Chat\Completions\ChatCompletionMessageCustomToolCall
 *
 * @phpstan-type ToolCallVariants = ChatCompletionMessageToolCall|ChatCompletionMessageCustomToolCall
 * @phpstan-type ToolCallShape = ToolCallVariants|ChatCompletionMessageToolCallShape|ChatCompletionMessageCustomToolCallShape
 */
final class ToolCall implements ConverterSource
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
            'function' => ChatCompletionMessageToolCall::class,
            'custom' => ChatCompletionMessageCustomToolCall::class,
        ];
    }
}
