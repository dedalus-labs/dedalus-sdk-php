<?php

declare(strict_types=1);

namespace DedalusSDK;

use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\Core\Conversion\MapOf;
use DedalusSDK\ToolChoice\MCPToolChoice;
use DedalusSDK\ToolChoice\UnionMember0;

/**
 * @phpstan-import-type MCPToolChoiceShape from \DedalusSDK\ToolChoice\MCPToolChoice
 *
 * @phpstan-type ToolChoiceVariants = string|MCPToolChoice|value-of<UnionMember0>|array<string,mixed>
 * @phpstan-type ToolChoiceShape = ToolChoiceVariants|MCPToolChoiceShape
 */
final class ToolChoice implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            UnionMember0::class, 'string', new MapOf('mixed'), MCPToolChoice::class,
        ];
    }
}
