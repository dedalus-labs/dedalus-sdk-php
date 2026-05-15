<?php

declare(strict_types=1);

namespace DedalusSDK\Responses\Response;

/**
 * The status of the response generation.
 */
enum Status: string
{
    case COMPLETED = 'completed';

    case FAILED = 'failed';

    case IN_PROGRESS = 'in_progress';

    case CANCELLED = 'cancelled';

    case QUEUED = 'queued';

    case INCOMPLETE = 'incomplete';
}
