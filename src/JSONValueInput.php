<?php

declare(strict_types=1);

namespace DedalusSDK;

use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\Core\Conversion\ListOf;
use DedalusSDK\Core\Conversion\MapOf;

/**
 * @phpstan-type JSONValueInputVariants = string|float|bool|list<mixed>|array<string,mixed>
 * @phpstan-type JSONValueInputShape = JSONValueInputVariants|list<JSONValueInputShape>|array<string,JSONValueInputShape>
 */
final class JSONValueInput implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'string',
            'float',
            'bool',
            new MapOf(JSONValueInput::class, nullable: true),
            new ListOf(JSONValueInput::class, nullable: true),
        ];
    }
}
