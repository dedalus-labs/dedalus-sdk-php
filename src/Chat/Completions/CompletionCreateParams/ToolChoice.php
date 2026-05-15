<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\CompletionCreateParams;

use DedalusSDK\Chat\Completions\ToolChoiceAny;
use DedalusSDK\Chat\Completions\ToolChoiceAuto;
use DedalusSDK\Chat\Completions\ToolChoiceNone;
use DedalusSDK\Chat\Completions\ToolChoiceTool;
use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;

/**
 * Controls which (if any) tool is called by the model. `none` means the model will not call any tool and instead generates a message. `auto` means the model can pick between generating a message or calling one or more tools. `required` means the model must call one or more tools. Specifying a particular tool via `{"type": "function", "function": {"name": "my_function"}}` forces the model to call that tool.  `none` is the default when no tools are present. `auto` is the default if tools are present.
 *
 * @phpstan-import-type ToolChoiceAutoShape from \DedalusSDK\Chat\Completions\ToolChoiceAuto
 * @phpstan-import-type ToolChoiceAnyShape from \DedalusSDK\Chat\Completions\ToolChoiceAny
 * @phpstan-import-type ToolChoiceToolShape from \DedalusSDK\Chat\Completions\ToolChoiceTool
 * @phpstan-import-type ToolChoiceNoneShape from \DedalusSDK\Chat\Completions\ToolChoiceNone
 *
 * @phpstan-type ToolChoiceVariants = string|ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone
 * @phpstan-type ToolChoiceShape = ToolChoiceVariants|ToolChoiceAutoShape|ToolChoiceAnyShape|ToolChoiceToolShape|ToolChoiceNoneShape
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
            'string',
            ToolChoiceAuto::class,
            ToolChoiceAny::class,
            ToolChoiceTool::class,
            ToolChoiceNone::class,
        ];
    }
}
