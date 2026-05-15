<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionCreateParams;

use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\Core\Conversion\ListOf;

/**
 * Sequences that stop generation.
 *
 * @phpstan-type StopVariants = string|list<string>
 * @phpstan-type StopShape = StopVariants
 */
final class Stop implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [new ListOf('string'), 'string'];
    }
}
