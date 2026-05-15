<?php

declare(strict_types=1);

namespace DedalusSDK\Core\Conversion;

use DedalusSDK\Core\Conversion\Concerns\ArrayOf;
use DedalusSDK\Core\Conversion\Contracts\Converter;

/**
 * @internal
 */
final class MapOf implements Converter
{
    use ArrayOf;
}
