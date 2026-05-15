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
 * A system (or developer) message inserted into the model's context.
 *
 * When using along with `previous_response_id`, the instructions from a previous
 * response will not be carried over to the next response. This makes it simple
 * to swap out system (or developer) messages in new responses.
 *
 * @phpstan-type InstructionsVariants = string|list<mixed>
 * @phpstan-type InstructionsShape = InstructionsVariants
 */
final class Instructions implements ConverterSource
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
