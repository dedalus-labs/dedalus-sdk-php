<?php

declare(strict_types=1);

namespace DedalusSDK\Services\Chat;

use DedalusSDK\Chat\Completions\ChatCompletion;
use DedalusSDK\Chat\Completions\ChatCompletionAudioParam;
use DedalusSDK\Chat\Completions\ChatCompletionChunk;
use DedalusSDK\Chat\Completions\ChatCompletionFunctions;
use DedalusSDK\Chat\Completions\ChatCompletionToolParam;
use DedalusSDK\Chat\Completions\CompletionCreateParams;
use DedalusSDK\Chat\Completions\CompletionCreateParams\PromptMode;
use DedalusSDK\Chat\Completions\CompletionCreateParams\SafetySetting;
use DedalusSDK\Chat\Completions\CompletionCreateParams\Speed;
use DedalusSDK\Chat\Completions\PredictionContent;
use DedalusSDK\Client;
use DedalusSDK\Core\Contracts\BaseResponse;
use DedalusSDK\Core\Contracts\BaseStream;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\RequestOptions;
use DedalusSDK\ServiceContracts\Chat\CompletionsRawContract;
use DedalusSDK\SSEStream;

/**
 * @phpstan-import-type ModelShape from \DedalusSDK\Chat\Completions\CompletionCreateParams\Model
 * @phpstan-import-type ChatCompletionAudioParamShape from \DedalusSDK\Chat\Completions\ChatCompletionAudioParam
 * @phpstan-import-type CredentialsShape from \DedalusSDK\Chat\Completions\CompletionCreateParams\Credentials
 * @phpstan-import-type ChatCompletionFunctionsShape from \DedalusSDK\Chat\Completions\ChatCompletionFunctions
 * @phpstan-import-type MCPServersShape from \DedalusSDK\Chat\Completions\CompletionCreateParams\MCPServers
 * @phpstan-import-type MessageShape from \DedalusSDK\Chat\Completions\CompletionCreateParams\Message
 * @phpstan-import-type PredictionContentShape from \DedalusSDK\Chat\Completions\PredictionContent
 * @phpstan-import-type ResponseFormatShape from \DedalusSDK\Chat\Completions\CompletionCreateParams\ResponseFormat
 * @phpstan-import-type SafetySettingShape from \DedalusSDK\Chat\Completions\CompletionCreateParams\SafetySetting
 * @phpstan-import-type StopShape from \DedalusSDK\Chat\Completions\CompletionCreateParams\Stop
 * @phpstan-import-type SystemInstructionShape from \DedalusSDK\Chat\Completions\CompletionCreateParams\SystemInstruction
 * @phpstan-import-type ThinkingShape from \DedalusSDK\Chat\Completions\CompletionCreateParams\Thinking
 * @phpstan-import-type ToolChoiceShape from \DedalusSDK\Chat\Completions\CompletionCreateParams\ToolChoice
 * @phpstan-import-type ChatCompletionToolParamShape from \DedalusSDK\Chat\Completions\ChatCompletionToolParam
 * @phpstan-import-type RequestOpts from \DedalusSDK\RequestOptions
 */
final class CompletionsRawService implements CompletionsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a chat completion.
     *
     * Generates a model response for the given conversation and configuration.
     * Supports OpenAI-compatible parameters and provider-specific extensions.
     *
     * Headers:
     *   - Authorization: bearer key for the calling account.
     *   - X-Provider / X-Provider-Key: optional headers for using your own provider API key.
     *
     * Behavior:
     *   - If multiple models are supplied, the first one is used, and the agent may hand off to another model.
     *   - Tools may be invoked on the server or signaled for the client to run.
     *   - Streaming responses emit incremental deltas; non-streaming returns a single object.
     *   - Usage metrics are computed when available and returned in the response.
     *
     * Responses:
     *   - 200 OK: JSON completion object with choices, message content, and usage.
     *   - 400 Bad Request: validation error.
     *   - 401 Unauthorized: authentication failed.
     *   - 402 Payment Required or 429 Too Many Requests: quota, balance, or rate limit issue.
     *   - 500 Internal Server Error: unexpected failure.
     *
     * Billing:
     *   - Token usage metered by the selected model(s).
     *   - Tool calls and MCP sessions may be billed separately.
     *   - Streaming is settled after the stream ends via an async task.
     *
     * Example (non-streaming HTTP):
     *   POST /v1/chat/completions
     *   Content-Type: application/json
     *   Authorization: Bearer <key>
     *
     *   {
     *     "model": "provider/model-name",
     *     "messages": [{"role": "user", "content": "Hello"}]
     *   }
     *
     *   200 OK
     *   {
     *     "id": "cmpl_123",
     *     "object": "chat.completion",
     *     "choices": [
     *       {"index": 0, "message": {"role": "assistant", "content": "Hi there!"}, "finish_reason": "stop"}
     *     ],
     *     "usage": {"prompt_tokens": 3, "completion_tokens": 4, "total_tokens": 7}
     *   }
     *
     * Example (streaming over SSE):
     *   POST /v1/chat/completions
     *   Accept: text/event-stream
     *
     *   data: {"id":"cmpl_123","choices":[{"index":0,"delta":{"content":"Hi"}}]}
     *   data: {"id":"cmpl_123","choices":[{"index":0,"delta":{"content":" there!"}}]}
     *   data: [DONE]
     *
     * @param array{
     *   model: ModelShape,
     *   agentAttributes?: array<string,float>|null,
     *   audio?: ChatCompletionAudioParam|ChatCompletionAudioParamShape|null,
     *   automaticToolExecution?: bool,
     *   cachedContent?: string|null,
     *   correlationID?: string|null,
     *   credentials?: CredentialsShape|null,
     *   deferred?: bool|null,
     *   deferredCalls?: list<mixed>|null,
     *   frequencyPenalty?: float|null,
     *   functionCall?: string|null,
     *   functions?: list<ChatCompletionFunctions|ChatCompletionFunctionsShape>|null,
     *   generationConfig?: array<string,mixed>|null,
     *   guardrails?: list<array<string,mixed>>|null,
     *   handoffConfig?: array<string,mixed>|null,
     *   handoffMode?: bool|null,
     *   inferenceGeo?: string|null,
     *   logitBias?: array<string,int>|null,
     *   logprobs?: bool|null,
     *   maxCompletionTokens?: int|null,
     *   maxTokens?: int|null,
     *   maxTurns?: int|null,
     *   mcpServers?: MCPServersShape|null,
     *   messages?: list<MessageShape>|null,
     *   metadata?: array<string,mixed>|null,
     *   modalities?: list<string>|null,
     *   modelAttributes?: array<string,array<string,float>>|null,
     *   n?: int|null,
     *   outputConfig?: array<string,mixed>|null,
     *   parallelToolCalls?: bool|null,
     *   prediction?: PredictionContent|PredictionContentShape|null,
     *   presencePenalty?: float|null,
     *   promptCacheKey?: string|null,
     *   promptCacheRetention?: string|null,
     *   promptMode?: PromptMode|value-of<PromptMode>|null,
     *   reasoningEffort?: string|null,
     *   responseFormat?: ResponseFormatShape|null,
     *   safePrompt?: bool|null,
     *   safetyIdentifier?: string|null,
     *   safetySettings?: list<SafetySetting|SafetySettingShape>|null,
     *   searchParameters?: array<string,mixed>|null,
     *   seed?: int|null,
     *   serviceTier?: string|null,
     *   speed?: Speed|value-of<Speed>|null,
     *   stop?: StopShape|null,
     *   store?: bool|null,
     *   streamOptions?: array<string,mixed>|null,
     *   systemInstruction?: SystemInstructionShape|null,
     *   temperature?: float|null,
     *   thinking?: ThinkingShape|null,
     *   toolChoice?: ToolChoiceShape|null,
     *   toolConfig?: array<string,mixed>|null,
     *   tools?: list<ChatCompletionToolParam|ChatCompletionToolParamShape>|null,
     *   topK?: int|null,
     *   topLogprobs?: int|null,
     *   topP?: float|null,
     *   user?: string|null,
     *   verbosity?: string|null,
     *   webSearchOptions?: array<string,mixed>|null,
     * }|CompletionCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ChatCompletion>
     *
     * @throws APIException
     */
    public function create(
        array|CompletionCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CompletionCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/chat/completions',
            body: (object) $parsed,
            options: $options,
            convert: ChatCompletion::class,
        );
    }

    /**
     * @api
     *
     * @param array{
     *   model: ModelShape,
     *   agentAttributes?: array<string,float>|null,
     *   audio?: ChatCompletionAudioParam|ChatCompletionAudioParamShape|null,
     *   automaticToolExecution?: bool,
     *   cachedContent?: string|null,
     *   correlationID?: string|null,
     *   credentials?: CredentialsShape|null,
     *   deferred?: bool|null,
     *   deferredCalls?: list<mixed>|null,
     *   frequencyPenalty?: float|null,
     *   functionCall?: string|null,
     *   functions?: list<ChatCompletionFunctions|ChatCompletionFunctionsShape>|null,
     *   generationConfig?: array<string,mixed>|null,
     *   guardrails?: list<array<string,mixed>>|null,
     *   handoffConfig?: array<string,mixed>|null,
     *   handoffMode?: bool|null,
     *   inferenceGeo?: string|null,
     *   logitBias?: array<string,int>|null,
     *   logprobs?: bool|null,
     *   maxCompletionTokens?: int|null,
     *   maxTokens?: int|null,
     *   maxTurns?: int|null,
     *   mcpServers?: MCPServersShape|null,
     *   messages?: list<MessageShape>|null,
     *   metadata?: array<string,mixed>|null,
     *   modalities?: list<string>|null,
     *   modelAttributes?: array<string,array<string,float>>|null,
     *   n?: int|null,
     *   outputConfig?: array<string,mixed>|null,
     *   parallelToolCalls?: bool|null,
     *   prediction?: PredictionContent|PredictionContentShape|null,
     *   presencePenalty?: float|null,
     *   promptCacheKey?: string|null,
     *   promptCacheRetention?: string|null,
     *   promptMode?: PromptMode|value-of<PromptMode>|null,
     *   reasoningEffort?: string|null,
     *   responseFormat?: ResponseFormatShape|null,
     *   safePrompt?: bool|null,
     *   safetyIdentifier?: string|null,
     *   safetySettings?: list<SafetySetting|SafetySettingShape>|null,
     *   searchParameters?: array<string,mixed>|null,
     *   seed?: int|null,
     *   serviceTier?: string|null,
     *   speed?: Speed|value-of<Speed>|null,
     *   stop?: StopShape|null,
     *   store?: bool|null,
     *   streamOptions?: array<string,mixed>|null,
     *   systemInstruction?: SystemInstructionShape|null,
     *   temperature?: float|null,
     *   thinking?: ThinkingShape|null,
     *   toolChoice?: ToolChoiceShape|null,
     *   toolConfig?: array<string,mixed>|null,
     *   tools?: list<ChatCompletionToolParam|ChatCompletionToolParamShape>|null,
     *   topK?: int|null,
     *   topLogprobs?: int|null,
     *   topP?: float|null,
     *   user?: string|null,
     *   verbosity?: string|null,
     *   webSearchOptions?: array<string,mixed>|null,
     * }|CompletionCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BaseStream<ChatCompletionChunk>>
     *
     * @throws APIException
     */
    public function createStream(
        array|CompletionCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CompletionCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $parsed['stream'] = true;

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/chat/completions',
            headers: ['Accept' => 'text/event-stream'],
            body: (object) $parsed,
            options: $options,
            convert: ChatCompletionChunk::class,
            stream: SSEStream::class,
        );
    }
}
