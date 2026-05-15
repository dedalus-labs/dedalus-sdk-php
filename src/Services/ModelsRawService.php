<?php

declare(strict_types=1);

namespace DedalusSDK\Services;

use DedalusSDK\Client;
use DedalusSDK\Core\Contracts\BaseResponse;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\Models\ListModelsResponse;
use DedalusSDK\Models\Model;
use DedalusSDK\RequestOptions;
use DedalusSDK\ServiceContracts\ModelsRawContract;

/**
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
final class ModelsRawService implements ModelsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieve a model.
     *
     * Retrieve detailed information about a specific model, including its capabilities,
     * provider, and supported features.
     *
     * Args:
     *     model_id: The ID of the model to retrieve (e.g., 'openai/gpt-4', 'anthropic/claude-3-5-sonnet-20241022')
     *     user: Authenticated user obtained from API key validation
     *
     * Returns:
     *     Model: Information about the requested model
     *
     * Raises:
     *     HTTPException:
     *         - 401 if authentication fails
     *         - 404 if model not found or not accessible with current API key
     *         - 500 if internal error occurs
     *
     * Requires:
     *     Valid API key with 'read' scope permission
     *
     * Example:
     *     ```python
     *     import dedalus_labs
     *
     *     client = dedalus_labs.Client(api_key="your-api-key")
     *     model = client.models.retrieve("openai/gpt-4")
     *
     *     print(f"Model: {model.id}")
     *     print(f"Owner: {model.owned_by}")
     *     ```
     *
     *     Response:
     *     ```json
     *     {
     *         "id": "openai/gpt-4",
     *         "object": "model",
     *         "created": 1687882411,
     *         "owned_by": "openai"
     *     }
     *     ```
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Model>
     *
     * @throws APIException
     */
    public function retrieve(
        string $modelID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/models/%1$s', $modelID],
            options: $requestOptions,
            convert: Model::class,
        );
    }

    /**
     * @api
     *
     * List available models.
     *
     * Retrieve the complete list of models available to your organization, including
     * models from OpenAI, Anthropic, Google, xAI, Mistral, Fireworks, and DeepSeek.
     *
     * Returns:
     *     ListModelsResponse: List of available models across all supported providers
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ListModelsResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/models',
            options: $requestOptions,
            convert: ListModelsResponse::class,
        );
    }
}
