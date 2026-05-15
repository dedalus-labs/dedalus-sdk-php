<?php

declare(strict_types=1);

namespace DedalusSDK\Reasoning;

enum Effort: string
{
    case NONE = 'none';

    case MINIMAL = 'minimal';

    case LOW = 'low';

    case MEDIUM = 'medium';

    case HIGH = 'high';

    case XHIGH = 'xhigh';
}
