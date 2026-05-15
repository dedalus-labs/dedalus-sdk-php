<?php

declare(strict_types=1);

namespace DedalusSDK\Reasoning;

enum Summary: string
{
    case AUTO = 'auto';

    case CONCISE = 'concise';

    case DETAILED = 'detailed';
}
