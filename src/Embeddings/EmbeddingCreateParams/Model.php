<?php

declare(strict_types=1);

namespace DedalusSDK\Embeddings\EmbeddingCreateParams;

/**
 * ID of the model to use. You can use the [List models](/docs/api-reference/models/list) API to see all of your available models, or see our [Model overview](/docs/models) for descriptions of them.
 */
enum Model: string
{
    case TEXT_EMBEDDING_ADA_002 = 'text-embedding-ada-002';

    case TEXT_EMBEDDING_3_SMALL = 'text-embedding-3-small';

    case TEXT_EMBEDDING_3_LARGE = 'text-embedding-3-large';
}
