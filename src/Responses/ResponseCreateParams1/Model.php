<?php

declare(strict_types=1);

namespace DedalusSDK\Responses\ResponseCreateParams1;

use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\Core\Conversion\ListOf;
use DedalusSDK\DedalusModel;
use DedalusSDK\DedalusModelChoice;

/**
 * Model ID used to generate the response, like `gpt-4o` or `o3`. OpenAI
 * offers a wide range of models with different capabilities, performance
 * characteristics, and price points. Refer to the [model guide](https://platform.openai.com/docs/models)
 * to browse and compare available models.
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
