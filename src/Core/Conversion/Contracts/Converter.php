<?php

declare(strict_types=1);

namespace DedalusSDK\Core\Conversion\Contracts;

use DedalusSDK\Core\Conversion\CoerceState;
use DedalusSDK\Core\Conversion\DumpState;

/**
 * @internal
 */
interface Converter
{
    /**
     * @internal
     */
    public function coerce(mixed $value, CoerceState $state): mixed;

    /**
     * @internal
     */
    public function dump(mixed $value, DumpState $state): mixed;
}
