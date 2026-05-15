<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionChunk;

/**
 * Specifies the processing type used for serving the request.
 *   - If set to 'auto', then the request will be processed with the service tier configured in the Project settings. Unless otherwise configured, the Project will use 'default'.
 *   - If set to 'default', then the request will be processed with the standard pricing and performance for the selected model.
 *   - If set to '[flex](/docs/guides/flex-processing)' or '[priority](https://openai.com/api-priority-processing/)', then the request will be processed with the corresponding service tier.
 *   - When not set, the default behavior is 'auto'.
 *
 *   When the `service_tier` parameter is set, the response body will include the `service_tier` value based on the processing mode actually used to serve the request. This response value may be different from the value set in the parameter.
 */
enum ServiceTier: string
{
    case AUTO = 'auto';

    case DEFAULT = 'default';

    case FLEX = 'flex';

    case SCALE = 'scale';

    case PRIORITY = 'priority';
}
