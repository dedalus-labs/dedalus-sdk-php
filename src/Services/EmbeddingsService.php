<?php

declare(strict_types=1);

namespace DedalusSDK\Services;

use DedalusSDK\Client;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\Core\Util;
use DedalusSDK\Embeddings\CreateEmbeddingResponse;
use DedalusSDK\Embeddings\EmbeddingCreateParams\EncodingFormat;
use DedalusSDK\Embeddings\EmbeddingCreateParams\Model;
use DedalusSDK\RequestOptions;
use DedalusSDK\ServiceContracts\EmbeddingsContract;

/**
 * @phpstan-import-type InputShape from \DedalusSDK\Embeddings\EmbeddingCreateParams\Input
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
final class EmbeddingsService implements EmbeddingsContract
{
    /**
     * @api
     */
    public EmbeddingsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new EmbeddingsRawService($client);
    }

    /**
     * @api
     *
     * Create embeddings using the configured provider.
     *
     * @param InputShape $input Input text to embed, encoded as a string or array of tokens. To embed multiple inputs in a single request, pass an array of strings or array of token arrays. The input must not exceed the max input tokens for the model (8192 tokens for all embedding models), cannot be an empty string, and any array must be 2048 dimensions or less. [Example Python code](https://cookbook.openai.com/examples/how_to_count_tokens_with_tiktoken) for counting tokens. In addition to the per-input token limit, all embedding  models enforce a maximum of 300,000 tokens summed across all inputs in a  single request.
     * @param string|Model|value-of<Model> $model ID of the model to use. You can use the [List models](/docs/api-reference/models/list) API to see all of your available models, or see our [Model overview](/docs/models) for descriptions of them.
     * @param int $dimensions The number of dimensions the resulting output embeddings should have. Only supported in `text-embedding-3` and later models.
     * @param EncodingFormat|value-of<EncodingFormat> $encodingFormat The format to return the embeddings in. Can be either `float` or [`base64`](https://pypi.org/project/pybase64/).
     * @param string $user A unique identifier representing your end-user, which can help OpenAI to monitor and detect abuse. [Learn more](/docs/guides/safety-best-practices#end-user-ids).
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string|array $input,
        Model|string $model,
        ?int $dimensions = null,
        EncodingFormat|string $encodingFormat = 'float',
        ?string $user = null,
        RequestOptions|array|null $requestOptions = null,
    ): CreateEmbeddingResponse {
        $params = Util::removeNulls(
            [
                'input' => $input,
                'model' => $model,
                'dimensions' => $dimensions,
                'encodingFormat' => $encodingFormat,
                'user' => $user,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
