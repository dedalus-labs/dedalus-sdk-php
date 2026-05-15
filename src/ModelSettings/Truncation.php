<?php

declare(strict_types=1);

namespace DedalusSDK\ModelSettings;

enum Truncation: string
{
    case AUTO = 'auto';

    case DISABLED = 'disabled';
}
