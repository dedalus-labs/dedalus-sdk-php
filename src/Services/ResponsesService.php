<?php

declare(strict_types=1);

namespace DedalusSDK\Services;

use DedalusSDK\Client;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\Core\Util;
use DedalusSDK\Credential;
use DedalusSDK\DedalusModel;
use DedalusSDK\MCPServerSpec;
use DedalusSDK\RequestOptions;
use DedalusSDK\Responses\Response;
use DedalusSDK\Responses\ResponseCreateParams1\Conversation\ResponseConversationParam;
use DedalusSDK\Responses\ResponseCreateParams1\Prompt;
use DedalusSDK\Responses\ResponseCreateParams1\ServiceTier;
use DedalusSDK\Responses\ResponseCreateParams1\Truncation;
use DedalusSDK\ServiceContracts\ResponsesContract;

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
final class ResponsesService implements ResponsesContract
{
    /**
     * @api
     */
    public ResponsesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ResponsesRawService($client);
    }

    /**
     * @api
     *
     * Create a response using the OpenAI Responses API.
     *
     * This endpoint routes directly to OpenAI's Responses API.
     * Only OpenAI models are supported.
     *
     * @param bool|null $background Whether to run the model response in the background.
     * [Learn more](https://platform.openai.com/docs/guides/background).
     * @param ConversationShape|null $conversation Conversation that this response belongs to. Items from this conversation are prepended to the input items, and output items from this response are automatically added after completion.
     * @param CredentialsShape|null $credentials Credentials for MCP server authentication. Each credential is matched to servers by connection name.
     * @param float|null $frequencyPenalty penalizes new tokens based on their frequency in the text so far
     * @param list<string>|null $include Specify additional output data to include in the model response. Currently
     * supported values are:
     * - `web_search_call.action.sources`: Include the sources of the web search tool call.
     * - `code_interpreter_call.outputs`: Includes the outputs of python code execution
     *   in code interpreter tool call items.
     * - `computer_call_output.output.image_url`: Include image urls from the computer call output.
     * - `file_search_call.results`: Include the search results of
     *   the file search tool call.
     * - `message.input_image.image_url`: Include image urls from the input message.
     * - `message.output_text.logprobs`: Include logprobs with assistant messages.
     * - `reasoning.encrypted_content`: Includes an encrypted version of reasoning
     *   tokens in reasoning item outputs. This enables reasoning items to be used in
     *   multi-turn conversations when using the Responses API statelessly (like
     *   when the `store` parameter is set to `false`, or when an organization is
     *   enrolled in the zero data retention program).
     * @param InputShape|null $input Text, image, or file inputs to the model, used to generate a response.
     *
     * Learn more:
     * - [Text inputs and outputs](https://platform.openai.com/docs/guides/text)
     * - [Image inputs](https://platform.openai.com/docs/guides/images)
     * - [File inputs](https://platform.openai.com/docs/guides/pdf-files)
     * - [Conversation state](https://platform.openai.com/docs/guides/conversation-state)
     * - [Function calling](https://platform.openai.com/docs/guides/function-calling)
     * @param InstructionsShape|null $instructions A system (or developer) message inserted into the model's context.
     *
     * When using along with `previous_response_id`, the instructions from a previous
     * response will not be carried over to the next response. This makes it simple
     * to swap out system (or developer) messages in new responses.
     * @param int|null $maxOutputTokens An upper bound for the number of tokens that can be generated for a response, including visible output tokens and [reasoning tokens](https://platform.openai.com/docs/guides/reasoning).
     * @param int|null $maxToolCalls The maximum number of total calls to built-in tools that can be processed in a response. This maximum number applies across all built-in tool calls, not per individual tool. Any further attempts to call a tool by the model will be ignored.
     * @param MCPServersShape|null $mcpServers MCP server identifiers. Accepts marketplace slugs, URLs, or MCPServerSpec objects. MCP tools are executed server-side and billed separately.
     * @param array<string,string>|null $metadata set of up to 16 key-value string pairs that can be attached to the response for structured metadata and later querying via the API or dashboard
     * @param ModelShape|null $model Model ID used to generate the response, like `gpt-4o` or `o3`. OpenAI
     * offers a wide range of models with different capabilities, performance
     * characteristics, and price points. Refer to the [model guide](https://platform.openai.com/docs/models)
     * to browse and compare available models.
     * @param bool|null $parallelToolCalls whether to allow the model to run tool calls in parallel
     * @param float|null $presencePenalty penalizes new tokens based on whether they appear in the text so far
     * @param string|null $previousResponseID Unique ID of the previous response to continue from when creating multi-turn conversations. Cannot be used together with `conversation`.
     * @param Prompt|PromptShape|null $prompt stored prompt template reference (BYOK)
     * @param string|null $promptCacheKey Used by OpenAI to cache responses for similar requests to optimize your cache hit rates. Replaces the `user` field. [Learn more](https://platform.openai.com/docs/guides/prompt-caching).
     * @param array<string,mixed>|null $reasoning **gpt-5 and o-series models only**
     *
     * Configuration options for
     * [reasoning models](https://platform.openai.com/docs/guides/reasoning).
     * @param string|null $safetyIdentifier A stable identifier used to help detect users of your application that may be violating OpenAI's usage policies.
     * The IDs should be a string that uniquely identifies each user. We recommend hashing their username or email address, in order to avoid sending us any identifying information. [Learn more](https://platform.openai.com/docs/guides/safety-best-practices#safety-identifiers).
     * @param ServiceTier|value-of<ServiceTier>|null $serviceTier Specifies the processing type used for serving the request.
     *   - If set to 'auto', then the request will be processed with the service tier configured in the Project settings. Unless otherwise configured, the Project will use 'default'.
     *   - If set to 'default', then the request will be processed with the standard pricing and performance for the selected model.
     *   - If set to '[flex](https://platform.openai.com/docs/guides/flex-processing)' or '[priority](https://openai.com/api-priority-processing/)', then the request will be processed with the corresponding service tier.
     *   - When not set, the default behavior is 'auto'.
     *
     *   When the `service_tier` parameter is set, the response body will include the `service_tier` value based on the processing mode actually used to serve the request. This response value may be different from the value set in the parameter.
     * @param bool|null $store whether to store the generated response for later retrieval via the Responses API
     * @param bool $stream If set to true, the model response data will be streamed to the client
     * as it is generated using [server-sent events](https://developer.mozilla.org/en-US/docs/Web/API/Server-sent_events/Using_server-sent_events#Event_stream_format).
     * See the [Streaming section below](https://platform.openai.com/docs/api-reference/responses-streaming)
     * for more information.
     * @param array<string,mixed>|null $streamOptions Options for streaming response. Only set this when you set `stream: true`.
     * @param float|null $temperature What sampling temperature to use, between 0 and 2. Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic.
     * We generally recommend altering this or `top_p` but not both.
     * @param array<string,mixed>|null $text Configuration options for a text response from the model. Can be plain
     * text or structured JSON data. Learn more:
     * - [Text inputs and outputs](https://platform.openai.com/docs/guides/text)
     * - [Structured Outputs](https://platform.openai.com/docs/guides/structured-outputs)
     * @param ToolChoiceShape|null $toolChoice How the model should select which tool (or tools) to use when generating
     * a response. See the `tools` parameter to see how to specify which tools
     * the model can call.
     * @param list<mixed>|null $tools An array of tools the model may call while generating a response. You
     * can specify which tool to use by setting the `tool_choice` parameter.
     *
     * We support the following categories of tools:
     * - **Built-in tools**: Tools that are provided by OpenAI that extend the
     *   model's capabilities, like [web search](https://platform.openai.com/docs/guides/tools-web-search)
     *   or [file search](https://platform.openai.com/docs/guides/tools-file-search). Learn more about
     *   [built-in tools](https://platform.openai.com/docs/guides/tools).
     * - **MCP Tools**: Integrations with third-party systems via custom MCP servers
     *   or predefined connectors such as Google Drive and SharePoint. Learn more about
     *   [MCP Tools](https://platform.openai.com/docs/guides/tools-connectors-mcp).
     * - **Function calls (custom tools)**: Functions that are defined by you,
     *   enabling the model to call your own code with strongly typed arguments
     *   and outputs. Learn more about
     *   [function calling](https://platform.openai.com/docs/guides/function-calling). You can also use
     *   custom tools to call your own code.
     * @param int|null $topLogprobs an integer between 0 and 20 specifying the number of most likely tokens to
     * return at each token position, each with an associated log probability
     * @param float|null $topP An alternative to sampling with temperature, called nucleus sampling,
     * where the model considers the results of the tokens with top_p probability
     * mass. So 0.1 means only the tokens comprising the top 10% probability mass
     * are considered.
     *
     * We generally recommend altering this or `temperature` but not both.
     * @param Truncation|value-of<Truncation>|null $truncation The truncation strategy to use for the model response.
     * - `auto`: If the input to this Response exceeds
     *   the model's context window size, the model will truncate the
     *   response to fit the context window by dropping items from the beginning of the conversation.
     * - `disabled` (default): If the input size will exceed the context window
     *   size for a model, the request will fail with a 400 error.
     * @param string|null $user This field is being replaced by `safety_identifier` and `prompt_cache_key`. Use `prompt_cache_key` instead to maintain caching optimizations.
     * A stable identifier for your end-users.
     * Used to boost cache hit rates by better bucketing similar requests and  to help OpenAI detect and prevent abuse. [Learn more](https://platform.openai.com/docs/guides/safety-best-practices#safety-identifiers).
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?bool $background = null,
        string|ResponseConversationParam|array|null $conversation = null,
        Credential|array|null $credentials = null,
        ?float $frequencyPenalty = null,
        ?array $include = null,
        string|array|null $input = null,
        string|array|null $instructions = null,
        ?int $maxOutputTokens = null,
        ?int $maxToolCalls = null,
        string|MCPServerSpec|array|null $mcpServers = null,
        ?array $metadata = null,
        string|DedalusModel|array|null $model = null,
        ?bool $parallelToolCalls = null,
        ?float $presencePenalty = null,
        ?string $previousResponseID = null,
        Prompt|array|null $prompt = null,
        ?string $promptCacheKey = null,
        ?array $reasoning = null,
        ?string $safetyIdentifier = null,
        ServiceTier|string|null $serviceTier = null,
        ?bool $store = null,
        bool $stream = false,
        ?array $streamOptions = null,
        ?float $temperature = null,
        ?array $text = null,
        string|array|null $toolChoice = null,
        ?array $tools = null,
        ?int $topLogprobs = null,
        ?float $topP = null,
        Truncation|string|null $truncation = null,
        ?string $user = null,
        RequestOptions|array|null $requestOptions = null,
    ): Response {
        $params = Util::removeNulls(
            [
                'background' => $background,
                'conversation' => $conversation,
                'credentials' => $credentials,
                'frequencyPenalty' => $frequencyPenalty,
                'include' => $include,
                'input' => $input,
                'instructions' => $instructions,
                'maxOutputTokens' => $maxOutputTokens,
                'maxToolCalls' => $maxToolCalls,
                'mcpServers' => $mcpServers,
                'metadata' => $metadata,
                'model' => $model,
                'parallelToolCalls' => $parallelToolCalls,
                'presencePenalty' => $presencePenalty,
                'previousResponseID' => $previousResponseID,
                'prompt' => $prompt,
                'promptCacheKey' => $promptCacheKey,
                'reasoning' => $reasoning,
                'safetyIdentifier' => $safetyIdentifier,
                'serviceTier' => $serviceTier,
                'store' => $store,
                'stream' => $stream,
                'streamOptions' => $streamOptions,
                'temperature' => $temperature,
                'text' => $text,
                'toolChoice' => $toolChoice,
                'tools' => $tools,
                'topLogprobs' => $topLogprobs,
                'topP' => $topP,
                'truncation' => $truncation,
                'user' => $user,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
