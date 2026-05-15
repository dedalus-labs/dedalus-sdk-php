<?php

declare(strict_types=1);

namespace DedalusSDK\Services;

use DedalusSDK\Client;
use DedalusSDK\Core\Contracts\BaseResponse;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\Embeddings\CreateEmbeddingResponse;
use DedalusSDK\Embeddings\EmbeddingCreateParams;
use DedalusSDK\Embeddings\EmbeddingCreateParams\EncodingFormat;
use DedalusSDK\Embeddings\EmbeddingCreateParams\Model;
use DedalusSDK\RequestOptions;
use DedalusSDK\ServiceContracts\EmbeddingsRawContract;

/**
 * @phpstan-import-type InputShape from \DedalusSDK\Embeddings\EmbeddingCreateParams\Input
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
final class EmbeddingsRawService implements EmbeddingsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create embeddings using the configured provider.
     *
     * @param array{
     *   input: InputShape,
     *   model: string|Model|value-of<Model>,
     *   dimensions?: int,
     *   encodingFormat?: EncodingFormat|value-of<EncodingFormat>,
     *   user?: string,
     * }|EmbeddingCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CreateEmbeddingResponse>
     *
     * @throws APIException
     */
    public function create(
        array|EmbeddingCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = EmbeddingCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/embeddings',
            body: (object) $parsed,
            options: $options,
            convert: CreateEmbeddingResponse::class,
        );
    }
}
