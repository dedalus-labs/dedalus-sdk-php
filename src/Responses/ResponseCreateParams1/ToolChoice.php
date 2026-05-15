<?php

declare(strict_types=1);

namespace DedalusSDK\Responses\ResponseCreateParams1;

use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\Core\Conversion\MapOf;
use DedalusSDK\JSONValueInput;

/**
 * How the model should select which tool (or tools) to use when generating
 * a response. See the `tools` parameter to see how to specify which tools
 * the model can call.
 *
 * @phpstan-import-type JSONValueInputShape from \DedalusSDK\JSONValueInput
 *
 * @phpstan-type ToolChoiceVariants = string|array<string,mixed>
 * @phpstan-type ToolChoiceShape = ToolChoiceVariants|array<string,JSONValueInputShape>
 */
final class ToolChoice implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', new MapOf(JSONValueInput::class, nullable: true)];
    }
}
