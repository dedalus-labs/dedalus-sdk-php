<?php

declare(strict_types=1);

namespace DedalusSDK\ServiceContracts;

use DedalusSDK\Core\Contracts\BaseResponse;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\Embeddings\CreateEmbeddingResponse;
use DedalusSDK\Embeddings\EmbeddingCreateParams;
use DedalusSDK\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
interface EmbeddingsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|EmbeddingCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CreateEmbeddingResponse>
     *
     * @throws APIException
     */
    public function create(
        array|EmbeddingCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
