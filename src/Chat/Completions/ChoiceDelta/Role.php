<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChoiceDelta;

/**
 * The role of the author of this message.
 */
enum Role: string
{
    case DEVELOPER = 'developer';

    case SYSTEM = 'system';

    case USER = 'user';

    case ASSISTANT = 'assistant';

    case TOOL = 'tool';
}
