<?php

declare(strict_types=1);

namespace DedalusSDK\Responses\Response;

use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\Core\Conversion\MapOf;
use DedalusSDK\JSONValueInput;

/**
 * Tool choice configuration used.
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
