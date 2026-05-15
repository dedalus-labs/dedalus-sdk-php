<?php

declare(strict_types=1);

namespace DedalusSDK;

use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;

/**
 * Dedalus model choice - either a string ID or DedalusModel configuration object.
 *
 * @phpstan-import-type DedalusModelShape from \DedalusSDK\DedalusModel
 *
 * @phpstan-type DedalusModelChoiceVariants = string|DedalusModel
 * @phpstan-type DedalusModelChoiceShape = DedalusModelChoiceVariants|DedalusModelShape
 */
final class DedalusModelChoice implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', DedalusModel::class];
    }
}
