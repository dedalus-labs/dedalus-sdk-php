<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\CompletionCreateParams;

use DedalusSDK\Chat\Completions\CompletionCreateParams\Thinking\ThinkingConfigAdaptive;
use DedalusSDK\Chat\Completions\ThinkingConfigDisabled;
use DedalusSDK\Chat\Completions\ThinkingConfigEnabled;
use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;

/**
 * Extended thinking configuration (Anthropic-specific).
 *
 * @phpstan-import-type ThinkingConfigEnabledShape from \DedalusSDK\Chat\Completions\ThinkingConfigEnabled
 * @phpstan-import-type ThinkingConfigDisabledShape from \DedalusSDK\Chat\Completions\ThinkingConfigDisabled
 * @phpstan-import-type ThinkingConfigAdaptiveShape from \DedalusSDK\Chat\Completions\CompletionCreateParams\Thinking\ThinkingConfigAdaptive
 *
 * @phpstan-type ThinkingVariants = ThinkingConfigEnabled|ThinkingConfigDisabled|ThinkingConfigAdaptive
 * @phpstan-type ThinkingShape = ThinkingVariants|ThinkingConfigEnabledShape|ThinkingConfigDisabledShape|ThinkingConfigAdaptiveShape
 */
final class Thinking implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'enabled' => ThinkingConfigEnabled::class,
            'disabled' => ThinkingConfigDisabled::class,
            'adaptive' => ThinkingConfigAdaptive::class,
        ];
    }
}
