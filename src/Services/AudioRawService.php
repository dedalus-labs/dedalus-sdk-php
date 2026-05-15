<?php

declare(strict_types=1);

namespace DedalusSDK\Services;

use DedalusSDK\Client;
use DedalusSDK\ServiceContracts\AudioRawContract;

final class AudioRawService implements AudioRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
