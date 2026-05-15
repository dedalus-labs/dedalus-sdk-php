<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\CompletionCreateParams;

use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\Core\Conversion\MapOf;
use DedalusSDK\JSONValueInput;

/**
 * System instruction/prompt.
 *
 * @phpstan-import-type JSONValueInputShape from \DedalusSDK\JSONValueInput
 *
 * @phpstan-type SystemInstructionVariants = string|array<string,mixed>
 * @phpstan-type SystemInstructionShape = SystemInstructionVariants|array<string,JSONValueInputShape>
 */
final class SystemInstruction implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [new MapOf(JSONValueInput::class, nullable: true), 'string'];
    }
}
