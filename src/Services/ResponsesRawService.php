<?php

declare(strict_types=1);

namespace DedalusSDK\Services;

use DedalusSDK\Client;
use DedalusSDK\Core\Contracts\BaseResponse;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\RequestOptions;
use DedalusSDK\Responses\Response;
use DedalusSDK\Responses\ResponseCreateParams1 as ResponseCreateParams;
use DedalusSDK\Responses\ResponseCreateParams1\Prompt;
use DedalusSDK\Responses\ResponseCreateParams1\ServiceTier;
use DedalusSDK\Responses\ResponseCreateParams1\Truncation;
use DedalusSDK\ServiceContracts\ResponsesRawContract;

/**
 * @phpstan-import-type ConversationShape from \DedalusSDK\Responses\ResponseCreateParams1\Conversation
 * @phpstan-import-type CredentialsShape from \DedalusSDK\Responses\ResponseCreateParams1\Credentials
 * @phpstan-import-type InputShape from \DedalusSDK\Responses\ResponseCreateParams1\Input
 * @phpstan-import-type InstructionsShape from \DedalusSDK\Responses\ResponseCreateParams1\Instructions
 * @phpstan-import-type MCPServersShape from \DedalusSDK\Responses\ResponseCreateParams1\MCPServers
 * @phpstan-import-type ModelShape from \DedalusSDK\Responses\ResponseCreateParams1\Model
 * @phpstan-import-type PromptShape from \DedalusSDK\Responses\ResponseCreateParams1\Prompt
 * @phpstan-import-type ToolChoiceShape from \DedalusSDK\Responses\ResponseCreateParams1\ToolChoice
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
final class ResponsesRawService implements ResponsesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a response using the OpenAI Responses API.
     *
     * This endpoint routes directly to OpenAI's Responses API.
     * Only OpenAI models are supported.
     *
     * @param array{
     *   background?: bool|null,
     *   conversation?: ConversationShape|null,
     *   credentials?: CredentialsShape|null,
     *   frequencyPenalty?: float|null,
     *   include?: list<string>|null,
     *   input?: InputShape|null,
     *   instructions?: InstructionsShape|null,
     *   maxOutputTokens?: int|null,
     *   maxToolCalls?: int|null,
     *   mcpServers?: MCPServersShape|null,
     *   metadata?: array<string,string>|null,
     *   model?: ModelShape|null,
     *   parallelToolCalls?: bool|null,
     *   presencePenalty?: float|null,
     *   previousResponseID?: string|null,
     *   prompt?: Prompt|PromptShape|null,
     *   promptCacheKey?: string|null,
     *   reasoning?: array<string,mixed>|null,
     *   safetyIdentifier?: string|null,
     *   serviceTier?: ServiceTier|value-of<ServiceTier>|null,
     *   store?: bool|null,
     *   stream?: bool,
     *   streamOptions?: array<string,mixed>|null,
     *   temperature?: float|null,
     *   text?: array<string,mixed>|null,
     *   toolChoice?: ToolChoiceShape|null,
     *   tools?: list<mixed>|null,
     *   topLogprobs?: int|null,
     *   topP?: float|null,
     *   truncation?: Truncation|value-of<Truncation>|null,
     *   user?: string|null,
     * }|ResponseCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Response>
     *
     * @throws APIException
     */
    public function create(
        array|ResponseCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ResponseCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/responses',
            body: (object) $parsed,
            options: $options,
            convert: Response::class,
        );
    }
}
