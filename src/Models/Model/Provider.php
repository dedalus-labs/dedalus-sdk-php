<?php

declare(strict_types=1);

namespace DedalusSDK\Models\Model;

/**
 * Provider that hosts this model.
 */
enum Provider: string
{
    case OPENAI = 'openai';

    case ANTHROPIC = 'anthropic';

    case GOOGLE = 'google';

    case XAI = 'xai';

    case MISTRAL = 'mistral';

    case GROQ = 'groq';

    case FIREWORKS = 'fireworks';

    case DEEPSEEK = 'deepseek';

    case MOONSHOT = 'moonshot';

    case CEREBRAS = 'cerebras';
}
