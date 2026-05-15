<?php

declare(strict_types=1);

namespace DedalusSDK\Responses\Response;

use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\Core\Conversion\ListOf;
use DedalusSDK\Core\Conversion\MapOf;
use DedalusSDK\JSONValueInput;

/**
 * System/developer instructions used.
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
