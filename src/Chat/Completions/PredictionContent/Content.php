<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\PredictionContent;

use DedalusSDK\Chat\Completions\ChatCompletionContentPartTextParam;
use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;
use DedalusSDK\Core\Conversion\ListOf;

/**
 * The content that should be matched when generating a model response.
 * If generated tokens would match this content, the entire model response
 * can be returned much more quickly.
 *
 * @phpstan-import-type ChatCompletionContentPartTextParamShape from \DedalusSDK\Chat\Completions\ChatCompletionContentPartTextParam
 *
 * @phpstan-type ContentVariants = string|list<ChatCompletionContentPartTextParam>
 * @phpstan-type ContentShape = ContentVariants|list<ChatCompletionContentPartTextParamShape>
 */
final class Content implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', new ListOf(ChatCompletionContentPartTextParam::class)];
    }
}
