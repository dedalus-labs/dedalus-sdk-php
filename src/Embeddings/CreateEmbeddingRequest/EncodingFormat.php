<?php

declare(strict_types=1);

namespace DedalusSDK\Embeddings\CreateEmbeddingRequest;

/**
 * The format to return the embeddings in. Can be either `float` or [`base64`](https://pypi.org/project/pybase64/).
 */
enum EncodingFormat: string
{
    case FLOAT = 'float';

    case BASE64 = 'base64';
}
