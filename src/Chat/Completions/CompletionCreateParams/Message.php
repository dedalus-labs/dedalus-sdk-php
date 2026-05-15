<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\CompletionCreateParams;

use DedalusSDK\Chat\Completions\ChatCompletionAssistantMessageParam;
use DedalusSDK\Chat\Completions\ChatCompletionDeveloperMessageParam;
use DedalusSDK\Chat\Completions\ChatCompletionFunctionMessageParam;
use DedalusSDK\Chat\Completions\ChatCompletionSystemMessageParam;
use DedalusSDK\Chat\Completions\ChatCompletionToolMessageParam;
use DedalusSDK\Chat\Completions\ChatCompletionUserMessageParam;
use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;

/**
 * Developer-provided instructions that the model should follow, regardless of
 * messages sent by the user. With o1 models and newer, `developer` messages
 * replace the previous `system` messages.
 *
 * Fields:
 * - content (required): str | Annotated[list[ChatCompletionRequestMessageContentPartText], MinLen(1), ArrayTitle("ChatCompletionRequestDeveloperMessageContentArray")]
 * - role (required): Literal["developer"]
 * - name (optional): str
 *
 * @phpstan-import-type ChatCompletionDeveloperMessageParamShape from \DedalusSDK\Chat\Completions\ChatCompletionDeveloperMessageParam
 * @phpstan-import-type ChatCompletionSystemMessageParamShape from \DedalusSDK\Chat\Completions\ChatCompletionSystemMessageParam
 * @phpstan-import-type ChatCompletionUserMessageParamShape from \DedalusSDK\Chat\Completions\ChatCompletionUserMessageParam
 * @phpstan-import-type ChatCompletionAssistantMessageParamShape from \DedalusSDK\Chat\Completions\ChatCompletionAssistantMessageParam
 * @phpstan-import-type ChatCompletionToolMessageParamShape from \DedalusSDK\Chat\Completions\ChatCompletionToolMessageParam
 * @phpstan-import-type ChatCompletionFunctionMessageParamShape from \DedalusSDK\Chat\Completions\ChatCompletionFunctionMessageParam
 *
 * @phpstan-type MessageVariants = ChatCompletionDeveloperMessageParam|ChatCompletionSystemMessageParam|ChatCompletionUserMessageParam|ChatCompletionAssistantMessageParam|ChatCompletionToolMessageParam|ChatCompletionFunctionMessageParam
 * @phpstan-type MessageShape = MessageVariants|ChatCompletionDeveloperMessageParamShape|ChatCompletionSystemMessageParamShape|ChatCompletionUserMessageParamShape|ChatCompletionAssistantMessageParamShape|ChatCompletionToolMessageParamShape|ChatCompletionFunctionMessageParamShape
 */
final class Message implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'role';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'developer' => ChatCompletionDeveloperMessageParam::class,
            'system' => ChatCompletionSystemMessageParam::class,
            'user' => ChatCompletionUserMessageParam::class,
            'assistant' => ChatCompletionAssistantMessageParam::class,
            'tool' => ChatCompletionToolMessageParam::class,
            'function' => ChatCompletionFunctionMessageParam::class,
        ];
    }
}
