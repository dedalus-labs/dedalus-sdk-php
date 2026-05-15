<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionCreateParams;

use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\Core\Conversion\ListOf;
use DedalusSDK\DedalusModel;
use DedalusSDK\DedalusModelChoice;

/**
 * Model identifier. Accepts model ID strings, lists for routing, or DedalusModel objects with per-model settings.
 *
 * @phpstan-import-type DedalusModelShape from \DedalusSDK\DedalusModel
 * @phpstan-import-type DedalusModelChoiceShape from \DedalusSDK\DedalusModelChoice
 *
 * @phpstan-type ModelVariants = string|DedalusModel|list<mixed>
 * @phpstan-type ModelShape = ModelVariants|DedalusModelShape|list<DedalusModelChoiceShape>
 */
final class Model implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'string', DedalusModel::class, new ListOf(DedalusModelChoice::class),
        ];
    }
}
