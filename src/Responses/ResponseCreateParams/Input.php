<?php

declare(strict_types=1);

namespace DedalusSDK\Responses\ResponseCreateParams;

use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\Core\Conversion\ListOf;
use DedalusSDK\Core\Conversion\MapOf;
use DedalusSDK\JSONValueInput;

/**
 * Text, image, or file inputs to the model, used to generate a response.
 *
 * Learn more:
 * - [Text inputs and outputs](https://platform.openai.com/docs/guides/text)
 * - [Image inputs](https://platform.openai.com/docs/guides/images)
 * - [File inputs](https://platform.openai.com/docs/guides/pdf-files)
 * - [Conversation state](https://platform.openai.com/docs/guides/conversation-state)
 * - [Function calling](https://platform.openai.com/docs/guides/function-calling)
 *
 * @phpstan-type InputVariants = string|list<mixed>
 * @phpstan-type InputShape = InputVariants
 */
final class Input implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'string', new ListOf(new MapOf(JSONValueInput::class, nullable: true)),
        ];
    }
}
