<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Chat\Completions\CompletionCreateParams\Credentials;
use DedalusSDK\Chat\Completions\CompletionCreateParams\MCPServers;
use DedalusSDK\Chat\Completions\CompletionCreateParams\Message;
use DedalusSDK\Chat\Completions\CompletionCreateParams\Model;
use DedalusSDK\Chat\Completions\CompletionCreateParams\PromptMode;
use DedalusSDK\Chat\Completions\CompletionCreateParams\ResponseFormat;
use DedalusSDK\Chat\Completions\CompletionCreateParams\SafetySetting;
use DedalusSDK\Chat\Completions\CompletionCreateParams\Speed;
use DedalusSDK\Chat\Completions\CompletionCreateParams\Stop;
use DedalusSDK\Chat\Completions\CompletionCreateParams\SystemInstruction;
use DedalusSDK\Chat\Completions\CompletionCreateParams\Thinking;
use DedalusSDK\Chat\Completions\CompletionCreateParams\Thinking\ThinkingConfigAdaptive;
use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Concerns\SdkParams;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\Core\Conversion\MapOf;
use DedalusSDK\Credential;
use DedalusSDK\DedalusModel;
use DedalusSDK\JSONValueInput;
use DedalusSDK\MCPServerSpec;
use DedalusSDK\ResponseFormatJSONObject;
use DedalusSDK\ResponseFormatJSONSchema;
use DedalusSDK\ResponseFormatText;

/**
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
 * @see DedalusSDK\Services\Chat\CompletionsService::create()
 *
 * @phpstan-import-type ModelVariants from \DedalusSDK\Chat\Completions\CompletionCreateParams\Model
 * @phpstan-import-type CredentialsVariants from \DedalusSDK\Chat\Completions\CompletionCreateParams\Credentials
 * @phpstan-import-type MCPServersVariants from \DedalusSDK\Chat\Completions\CompletionCreateParams\MCPServers
 * @phpstan-import-type MessageVariants from \DedalusSDK\Chat\Completions\CompletionCreateParams\Message
 * @phpstan-import-type ResponseFormatVariants from \DedalusSDK\Chat\Completions\CompletionCreateParams\ResponseFormat
 * @phpstan-import-type StopVariants from \DedalusSDK\Chat\Completions\CompletionCreateParams\Stop
 * @phpstan-import-type SystemInstructionVariants from \DedalusSDK\Chat\Completions\CompletionCreateParams\SystemInstruction
 * @phpstan-import-type ThinkingVariants from \DedalusSDK\Chat\Completions\CompletionCreateParams\Thinking
 * @phpstan-import-type ToolChoiceVariants from \DedalusSDK\Chat\Completions\CompletionCreateParams\ToolChoice
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
 *
 * @phpstan-type CompletionCreateParamsShape = array{
 *   model: ModelShape,
 *   agentAttributes?: array<string,float>|null,
 *   audio?: null|ChatCompletionAudioParam|ChatCompletionAudioParamShape,
 *   automaticToolExecution?: bool|null,
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
 *   prediction?: null|PredictionContent|PredictionContentShape,
 *   presencePenalty?: float|null,
 *   promptCacheKey?: string|null,
 *   promptCacheRetention?: string|null,
 *   promptMode?: null|PromptMode|value-of<PromptMode>,
 *   reasoningEffort?: string|null,
 *   responseFormat?: ResponseFormatShape|null,
 *   safePrompt?: bool|null,
 *   safetyIdentifier?: string|null,
 *   safetySettings?: list<SafetySetting|SafetySettingShape>|null,
 *   searchParameters?: array<string,mixed>|null,
 *   seed?: int|null,
 *   serviceTier?: string|null,
 *   speed?: null|Speed|value-of<Speed>,
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
 * }
 */
final class CompletionCreateParams implements BaseModel
{
    /** @use SdkModel<CompletionCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Model identifier. Accepts model ID strings, lists for routing, or DedalusModel objects with per-model settings.
     *
     * @var ModelVariants $model
     */
    #[Required(union: Model::class)]
    public string|DedalusModel|array $model;

    /**
     * Agent attributes. Values in [0.0, 1.0].
     *
     * @var array<string,float>|null $agentAttributes
     */
    #[Optional('agent_attributes', map: 'float', nullable: true)]
    public ?array $agentAttributes;

    /**
     * Parameters for audio output. Required when audio output is requested with
     * `modalities: ["audio"]`. [Learn more](/docs/guides/audio).
     *
     * Fields:
     * - voice (required): VoiceIdsOrCustomVoice
     * - format (required): Literal["wav", "aac", "mp3", "flac", "opus", "pcm16"]
     */
    #[Optional(nullable: true)]
    public ?ChatCompletionAudioParam $audio;

    /**
     * Execute tools server-side. If false, returns raw tool calls for manual handling.
     */
    #[Optional('automatic_tool_execution')]
    public ?bool $automaticToolExecution;

    /**
     * Optional. The name of the content [cached](https://ai.google.dev/gemini-api/docs/caching) to use as context to serve the prediction. Format: `cachedContents/{cachedContent}`.
     */
    #[Optional('cached_content', nullable: true)]
    public ?string $cachedContent;

    /**
     * Stable session ID for resuming a previous handoff. Returned by the server on handoff; echo it on the next request to resume.
     */
    #[Optional('correlation_id', nullable: true)]
    public ?string $correlationID;

    /**
     * Credentials for MCP server authentication. Each credential is matched to servers by connection name.
     *
     * @var CredentialsVariants|null $credentials
     */
    #[Optional(union: Credentials::class, nullable: true)]
    public Credential|array|null $credentials;

    /**
     * If set to `true`, the request returns a `request_id`. You can then get the deferred response by GET `/v1/chat/deferred-completion/{request_id}`.
     */
    #[Optional(nullable: true)]
    public ?bool $deferred;

    /**
     * Tier 2 stateless resumption. Deferred tool specs from a previous handoff response, sent back verbatim so the server can resume without Redis.
     *
     * @var list<mixed>|null $deferredCalls
     */
    #[Optional(
        'deferred_calls',
        list: DeferredCallResponse::class,
        nullable: true
    )]
    public ?array $deferredCalls;

    /**
     * Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.
     */
    #[Optional('frequency_penalty', nullable: true)]
    public ?float $frequencyPenalty;

    /**
     * Deprecated in favor of `tool_choice`.  Controls which (if any) function is called by the model.  `none` means the model will not call a function and instead generates a message.  `auto` means the model can pick between generating a message or calling a function.  Specifying a particular function via `{"name": "my_function"}` forces the model to call that function.  `none` is the default when no functions are present. `auto` is the default if functions are present.
     */
    #[Optional('function_call', nullable: true)]
    public ?string $functionCall;

    /**
     * Deprecated in favor of `tools`.  A list of functions the model may generate JSON inputs for.
     *
     * @var list<ChatCompletionFunctions>|null $functions
     */
    #[Optional(list: ChatCompletionFunctions::class, nullable: true)]
    public ?array $functions;

    /**
     * Generation parameters wrapper (Google-specific).
     *
     * @var array<string,mixed>|null $generationConfig
     */
    #[Optional(
        'generation_config',
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true,
    )]
    public ?array $generationConfig;

    /**
     * Content filtering and safety policy configuration.
     *
     * @var list<array<string,mixed>>|null $guardrails
     */
    #[Optional(list: new MapOf('mixed'), nullable: true)]
    public ?array $guardrails;

    /**
     * Configuration for multi-model handoffs.
     *
     * @var array<string,mixed>|null $handoffConfig
     */
    #[Optional('handoff_config', map: 'mixed', nullable: true)]
    public ?array $handoffConfig;

    /**
     * Handoff control. None or omitted: auto-detect. true: structured handoff (SDK). false: drop-in (LLM re-run for mixed turns).
     */
    #[Optional('handoff_mode', nullable: true)]
    public ?bool $handoffMode;

    /**
     * Specifies the geographic region for inference processing. If not specified, the workspace's `default_inference_geo` is used.
     */
    #[Optional('inference_geo', nullable: true)]
    public ?string $inferenceGeo;

    /**
     * Modify the likelihood of specified tokens appearing in the completion.  Accepts a JSON object that maps tokens (specified by their token ID in the tokenizer) to an associated bias value from -100 to 100. Mathematically, the bias is added to the logits generated by the model prior to sampling. The exact effect will vary per model, but values between -1 and 1 should decrease or increase likelihood of selection; values like -100 or 100 should result in a ban or exclusive selection of the relevant token.
     *
     * @var array<string,int>|null $logitBias
     */
    #[Optional('logit_bias', map: 'int', nullable: true)]
    public ?array $logitBias;

    /**
     * Whether to return log probabilities of the output tokens or not. If true, returns the log probabilities of each output token returned in the `content` of `message`.
     */
    #[Optional(nullable: true)]
    public ?bool $logprobs;

    /**
     * Maximum tokens in completion (newer parameter name).
     */
    #[Optional('max_completion_tokens', nullable: true)]
    public ?int $maxCompletionTokens;

    /**
     * Maximum tokens in completion.
     */
    #[Optional('max_tokens', nullable: true)]
    public ?int $maxTokens;

    /**
     * Maximum conversation turns.
     */
    #[Optional('max_turns', nullable: true)]
    public ?int $maxTurns;

    /**
     * MCP server identifiers. Accepts marketplace slugs, URLs, or MCPServerSpec objects. MCP tools are executed server-side and billed separately.
     *
     * @var MCPServersVariants|null $mcpServers
     */
    #[Optional('mcp_servers', union: MCPServers::class, nullable: true)]
    public string|MCPServerSpec|array|null $mcpServers;

    /**
     * Conversation history (OpenAI: messages, Google: contents, Responses: input).
     *
     * @var list<MessageVariants>|null $messages
     */
    #[Optional(list: Message::class, nullable: true)]
    public ?array $messages;

    /**
     * Set of 16 key-value pairs that can be attached to an object. This can be useful for storing additional information about the object in a structured format, and querying for objects via API or the dashboard.  Keys are strings with a maximum length of 64 characters. Values are strings with a maximum length of 512 characters.
     *
     * @var array<string,mixed>|null $metadata
     */
    #[Optional(
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true
    )]
    public ?array $metadata;

    /**
     * Output types that you would like the model to generate. Most models are capable of generating text, which is the default:  `["text"]`  The `gpt-4o-audio-preview` model can also be used to [generate audio](/docs/guides/audio). To request that this model generate both text and audio responses, you can use:  `["text", "audio"]`.
     *
     * @var list<string>|null $modalities
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $modalities;

    /**
     * Model attributes for routing. Maps model IDs to attribute dictionaries with values in [0.0, 1.0].
     *
     * @var array<string,array<string,float>>|null $modelAttributes
     */
    #[Optional('model_attributes', map: new MapOf('float'), nullable: true)]
    public ?array $modelAttributes;

    /**
     * How many chat completion choices to generate for each input message. Note that you will be charged based on the number of generated tokens across all of the choices. Keep `n` as `1` to minimize costs.
     */
    #[Optional(nullable: true)]
    public ?int $n;

    /** @var array<string,mixed>|null $outputConfig */
    #[Optional(
        'output_config',
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true,
    )]
    public ?array $outputConfig;

    /**
     * Whether to enable parallel tool calls (Anthropic uses inverted polarity).
     */
    #[Optional('parallel_tool_calls', nullable: true)]
    public ?bool $parallelToolCalls;

    /**
     * Static predicted output content, such as the content of a text file that is
     * being regenerated.
     *
     * Fields:
     * - type (required): Literal["content"]
     * - content (required): str | Annotated[list[ChatCompletionRequestMessageContentPartText], MinLen(1), ArrayTitle("PredictionContentArray")]
     */
    #[Optional(nullable: true)]
    public ?PredictionContent $prediction;

    /**
     * Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.
     */
    #[Optional('presence_penalty', nullable: true)]
    public ?float $presencePenalty;

    /**
     * Used by OpenAI to cache responses for similar requests to optimize your cache hit rates. Replaces the `user` field. [Learn more](/docs/guides/prompt-caching).
     */
    #[Optional('prompt_cache_key', nullable: true)]
    public ?string $promptCacheKey;

    /**
     * The retention policy for the prompt cache. Set to `24h` to enable extended prompt caching, which keeps cached prefixes active for longer, up to a maximum of 24 hours. [Learn more](/docs/guides/prompt-caching#prompt-cache-retention).
     */
    #[Optional('prompt_cache_retention', nullable: true)]
    public ?string $promptCacheRetention;

    /**
     * Allows toggling between the reasoning mode and no system prompt. When set to `reasoning` the system prompt for reasoning models will be used.
     *
     * @var value-of<PromptMode>|null $promptMode
     */
    #[Optional('prompt_mode', enum: PromptMode::class, nullable: true)]
    public ?string $promptMode;

    /**
     * Constrains effort on reasoning for [reasoning models](https://platform.openai.com/docs/guides/reasoning). Currently supported values are `none`, `minimal`, `low`, `medium`, `high`, and `xhigh`. Reducing reasoning effort can result in faster responses and fewer tokens used on reasoning in a response.  - `gpt-5.1` defaults to `none`, which does not perform reasoning. The supported reasoning values for `gpt-5.1` are `none`, `low`, `medium`, and `high`. Tool calls are supported for all reasoning values in gpt-5.1. - All models before `gpt-5.1` default to `medium` reasoning effort, and do not support `none`. - The `gpt-5-pro` model defaults to (and only supports) `high` reasoning effort. - `xhigh` is supported for all models after `gpt-5.1-codex-max`.
     */
    #[Optional('reasoning_effort', nullable: true)]
    public ?string $reasoningEffort;

    /**
     * An object specifying the format that the model must output.  Setting to `{ "type": "json_schema", "json_schema": {...} }` enables Structured Outputs which ensures the model will match your supplied JSON schema. Learn more in the [Structured Outputs guide](/docs/guides/structured-outputs).  Setting to `{ "type": "json_object" }` enables the older JSON mode, which ensures the message the model generates is valid JSON. Using `json_schema` is preferred for models that support it.
     *
     * @var ResponseFormatVariants|null $responseFormat
     */
    #[Optional('response_format', union: ResponseFormat::class, nullable: true)]
    public ResponseFormatText|ResponseFormatJSONSchema|ResponseFormatJSONObject|null $responseFormat;

    /**
     * Whether to inject a safety prompt before all conversations.
     */
    #[Optional('safe_prompt', nullable: true)]
    public ?bool $safePrompt;

    /**
     * A stable identifier used to help detect users of your application that may be violating OpenAI's usage policies. The IDs should be a string that uniquely identifies each user. We recommend hashing their username or email address, in order to avoid sending us any identifying information. [Learn more](/docs/guides/safety-best-practices#safety-identifiers).
     */
    #[Optional('safety_identifier', nullable: true)]
    public ?string $safetyIdentifier;

    /**
     * Safety/content filtering settings (Google-specific).
     *
     * @var list<SafetySetting>|null $safetySettings
     */
    #[Optional('safety_settings', list: SafetySetting::class, nullable: true)]
    public ?array $safetySettings;

    /**
     * Set the parameters to be used for searched data. If not set, no data will be acquired by the model.
     *
     * @var array<string,mixed>|null $searchParameters
     */
    #[Optional(
        'search_parameters',
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true,
    )]
    public ?array $searchParameters;

    /**
     * Random seed for deterministic output.
     */
    #[Optional(nullable: true)]
    public ?int $seed;

    /**
     * Service tier for request processing.
     */
    #[Optional('service_tier', nullable: true)]
    public ?string $serviceTier;

    /**
     * The inference speed mode for this request. `"fast"` enables high output-tokens-per-second inference.
     *
     * @var value-of<Speed>|null $speed
     */
    #[Optional(enum: Speed::class, nullable: true)]
    public ?string $speed;

    /**
     * Sequences that stop generation.
     *
     * @var StopVariants|null $stop
     */
    #[Optional(union: Stop::class, nullable: true)]
    public string|array|null $stop;

    /**
     * Whether or not to store the output of this chat completion request for use in our [model distillation](/docs/guides/distillation) or [evals](/docs/guides/evals) products.  Supports text and image inputs. Note: image inputs over 8MB will be dropped.
     */
    #[Optional(nullable: true)]
    public ?bool $store;

    /**
     * Options for streaming response. Only set this when you set `stream: true`.
     *
     * @var array<string,mixed>|null $streamOptions
     */
    #[Optional(
        'stream_options',
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true,
    )]
    public ?array $streamOptions;

    /**
     * System instruction/prompt.
     *
     * @var SystemInstructionVariants|null $systemInstruction
     */
    #[Optional(
        'system_instruction',
        union: SystemInstruction::class,
        nullable: true
    )]
    public string|array|null $systemInstruction;

    /**
     * Sampling temperature (0-2 for most providers).
     */
    #[Optional(nullable: true)]
    public ?float $temperature;

    /**
     * Extended thinking configuration (Anthropic-specific).
     *
     * @var ThinkingVariants|null $thinking
     */
    #[Optional(union: Thinking::class, nullable: true)]
    public ThinkingConfigEnabled|ThinkingConfigDisabled|ThinkingConfigAdaptive|null $thinking;

    /**
     * Controls which (if any) tool is called by the model. `none` means the model will not call any tool and instead generates a message. `auto` means the model can pick between generating a message or calling one or more tools. `required` means the model must call one or more tools. Specifying a particular tool via `{"type": "function", "function": {"name": "my_function"}}` forces the model to call that tool.  `none` is the default when no tools are present. `auto` is the default if tools are present.
     *
     * @var ToolChoiceVariants|null $toolChoice
     */
    #[Optional('tool_choice', nullable: true)]
    public string|ToolChoiceAuto|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone|null $toolChoice;

    /**
     * Tool calling configuration (Google-specific).
     *
     * @var array<string,mixed>|null $toolConfig
     */
    #[Optional(
        'tool_config',
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true,
    )]
    public ?array $toolConfig;

    /**
     * Available tools/functions for the model.
     *
     * @var list<ChatCompletionToolParam>|null $tools
     */
    #[Optional(list: ChatCompletionToolParam::class, nullable: true)]
    public ?array $tools;

    /**
     * Top-k sampling parameter.
     */
    #[Optional('top_k', nullable: true)]
    public ?int $topK;

    /**
     * An integer between 0 and 20 specifying the number of most likely tokens to return at each token position, each with an associated log probability. `logprobs` must be set to `true` if this parameter is used.
     */
    #[Optional('top_logprobs', nullable: true)]
    public ?int $topLogprobs;

    /**
     * Nucleus sampling threshold.
     */
    #[Optional('top_p', nullable: true)]
    public ?float $topP;

    /**
     * This field is being replaced by `safety_identifier` and `prompt_cache_key`. Use `prompt_cache_key` instead to maintain caching optimizations. A stable identifier for your end-users. Used to boost cache hit rates by better bucketing similar requests and  to help OpenAI detect and prevent abuse. [Learn more](/docs/guides/safety-best-practices#safety-identifiers).
     */
    #[Optional(nullable: true)]
    public ?string $user;

    /**
     * Constrains the verbosity of the model's response. Lower values will result in more concise responses, while higher values will result in more verbose responses. Currently supported values are `low`, `medium`, and `high`.
     */
    #[Optional(nullable: true)]
    public ?string $verbosity;

    /**
     * This tool searches the web for relevant results to use in a response. Learn more about the [web search tool](/docs/guides/tools-web-search?api-mode=chat).
     *
     * @var array<string,mixed>|null $webSearchOptions
     */
    #[Optional(
        'web_search_options',
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true,
    )]
    public ?array $webSearchOptions;

    /**
     * `new CompletionCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CompletionCreateParams::with(model: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CompletionCreateParams)->withModel(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ModelShape $model
     * @param array<string,float>|null $agentAttributes
     * @param ChatCompletionAudioParam|ChatCompletionAudioParamShape|null $audio
     * @param CredentialsShape|null $credentials
     * @param list<mixed>|null $deferredCalls
     * @param list<ChatCompletionFunctions|ChatCompletionFunctionsShape>|null $functions
     * @param array<string,mixed>|null $generationConfig
     * @param list<array<string,mixed>>|null $guardrails
     * @param array<string,mixed>|null $handoffConfig
     * @param array<string,int>|null $logitBias
     * @param MCPServersShape|null $mcpServers
     * @param list<MessageShape>|null $messages
     * @param array<string,mixed>|null $metadata
     * @param list<string>|null $modalities
     * @param array<string,array<string,float>>|null $modelAttributes
     * @param array<string,mixed>|null $outputConfig
     * @param PredictionContent|PredictionContentShape|null $prediction
     * @param PromptMode|value-of<PromptMode>|null $promptMode
     * @param ResponseFormatShape|null $responseFormat
     * @param list<SafetySetting|SafetySettingShape>|null $safetySettings
     * @param array<string,mixed>|null $searchParameters
     * @param Speed|value-of<Speed>|null $speed
     * @param StopShape|null $stop
     * @param array<string,mixed>|null $streamOptions
     * @param SystemInstructionShape|null $systemInstruction
     * @param ThinkingShape|null $thinking
     * @param ToolChoiceShape|null $toolChoice
     * @param array<string,mixed>|null $toolConfig
     * @param list<ChatCompletionToolParam|ChatCompletionToolParamShape>|null $tools
     * @param array<string,mixed>|null $webSearchOptions
     */
    public static function with(
        string|DedalusModel|array $model,
        ?array $agentAttributes = null,
        ChatCompletionAudioParam|array|null $audio = null,
        ?bool $automaticToolExecution = null,
        ?string $cachedContent = null,
        ?string $correlationID = null,
        Credential|array|null $credentials = null,
        ?bool $deferred = null,
        ?array $deferredCalls = null,
        ?float $frequencyPenalty = null,
        ?string $functionCall = null,
        ?array $functions = null,
        ?array $generationConfig = null,
        ?array $guardrails = null,
        ?array $handoffConfig = null,
        ?bool $handoffMode = null,
        ?string $inferenceGeo = null,
        ?array $logitBias = null,
        ?bool $logprobs = null,
        ?int $maxCompletionTokens = null,
        ?int $maxTokens = null,
        ?int $maxTurns = null,
        string|MCPServerSpec|array|null $mcpServers = null,
        ?array $messages = null,
        ?array $metadata = null,
        ?array $modalities = null,
        ?array $modelAttributes = null,
        ?int $n = null,
        ?array $outputConfig = null,
        ?bool $parallelToolCalls = null,
        PredictionContent|array|null $prediction = null,
        ?float $presencePenalty = null,
        ?string $promptCacheKey = null,
        ?string $promptCacheRetention = null,
        PromptMode|string|null $promptMode = null,
        ?string $reasoningEffort = null,
        ResponseFormatText|array|ResponseFormatJSONSchema|ResponseFormatJSONObject|null $responseFormat = null,
        ?bool $safePrompt = null,
        ?string $safetyIdentifier = null,
        ?array $safetySettings = null,
        ?array $searchParameters = null,
        ?int $seed = null,
        ?string $serviceTier = null,
        Speed|string|null $speed = null,
        string|array|null $stop = null,
        ?bool $store = null,
        ?array $streamOptions = null,
        string|array|null $systemInstruction = null,
        ?float $temperature = null,
        ThinkingConfigEnabled|array|ThinkingConfigDisabled|ThinkingConfigAdaptive|null $thinking = null,
        string|ToolChoiceAuto|array|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone|null $toolChoice = null,
        ?array $toolConfig = null,
        ?array $tools = null,
        ?int $topK = null,
        ?int $topLogprobs = null,
        ?float $topP = null,
        ?string $user = null,
        ?string $verbosity = null,
        ?array $webSearchOptions = null,
    ): self {
        $self = new self;

        $self['model'] = $model;

        null !== $agentAttributes && $self['agentAttributes'] = $agentAttributes;
        null !== $audio && $self['audio'] = $audio;
        null !== $automaticToolExecution && $self['automaticToolExecution'] = $automaticToolExecution;
        null !== $cachedContent && $self['cachedContent'] = $cachedContent;
        null !== $correlationID && $self['correlationID'] = $correlationID;
        null !== $credentials && $self['credentials'] = $credentials;
        null !== $deferred && $self['deferred'] = $deferred;
        null !== $deferredCalls && $self['deferredCalls'] = $deferredCalls;
        null !== $frequencyPenalty && $self['frequencyPenalty'] = $frequencyPenalty;
        null !== $functionCall && $self['functionCall'] = $functionCall;
        null !== $functions && $self['functions'] = $functions;
        null !== $generationConfig && $self['generationConfig'] = $generationConfig;
        null !== $guardrails && $self['guardrails'] = $guardrails;
        null !== $handoffConfig && $self['handoffConfig'] = $handoffConfig;
        null !== $handoffMode && $self['handoffMode'] = $handoffMode;
        null !== $inferenceGeo && $self['inferenceGeo'] = $inferenceGeo;
        null !== $logitBias && $self['logitBias'] = $logitBias;
        null !== $logprobs && $self['logprobs'] = $logprobs;
        null !== $maxCompletionTokens && $self['maxCompletionTokens'] = $maxCompletionTokens;
        null !== $maxTokens && $self['maxTokens'] = $maxTokens;
        null !== $maxTurns && $self['maxTurns'] = $maxTurns;
        null !== $mcpServers && $self['mcpServers'] = $mcpServers;
        null !== $messages && $self['messages'] = $messages;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $modalities && $self['modalities'] = $modalities;
        null !== $modelAttributes && $self['modelAttributes'] = $modelAttributes;
        null !== $n && $self['n'] = $n;
        null !== $outputConfig && $self['outputConfig'] = $outputConfig;
        null !== $parallelToolCalls && $self['parallelToolCalls'] = $parallelToolCalls;
        null !== $prediction && $self['prediction'] = $prediction;
        null !== $presencePenalty && $self['presencePenalty'] = $presencePenalty;
        null !== $promptCacheKey && $self['promptCacheKey'] = $promptCacheKey;
        null !== $promptCacheRetention && $self['promptCacheRetention'] = $promptCacheRetention;
        null !== $promptMode && $self['promptMode'] = $promptMode;
        null !== $reasoningEffort && $self['reasoningEffort'] = $reasoningEffort;
        null !== $responseFormat && $self['responseFormat'] = $responseFormat;
        null !== $safePrompt && $self['safePrompt'] = $safePrompt;
        null !== $safetyIdentifier && $self['safetyIdentifier'] = $safetyIdentifier;
        null !== $safetySettings && $self['safetySettings'] = $safetySettings;
        null !== $searchParameters && $self['searchParameters'] = $searchParameters;
        null !== $seed && $self['seed'] = $seed;
        null !== $serviceTier && $self['serviceTier'] = $serviceTier;
        null !== $speed && $self['speed'] = $speed;
        null !== $stop && $self['stop'] = $stop;
        null !== $store && $self['store'] = $store;
        null !== $streamOptions && $self['streamOptions'] = $streamOptions;
        null !== $systemInstruction && $self['systemInstruction'] = $systemInstruction;
        null !== $temperature && $self['temperature'] = $temperature;
        null !== $thinking && $self['thinking'] = $thinking;
        null !== $toolChoice && $self['toolChoice'] = $toolChoice;
        null !== $toolConfig && $self['toolConfig'] = $toolConfig;
        null !== $tools && $self['tools'] = $tools;
        null !== $topK && $self['topK'] = $topK;
        null !== $topLogprobs && $self['topLogprobs'] = $topLogprobs;
        null !== $topP && $self['topP'] = $topP;
        null !== $user && $self['user'] = $user;
        null !== $verbosity && $self['verbosity'] = $verbosity;
        null !== $webSearchOptions && $self['webSearchOptions'] = $webSearchOptions;

        return $self;
    }

    /**
     * Model identifier. Accepts model ID strings, lists for routing, or DedalusModel objects with per-model settings.
     *
     * @param ModelShape $model
     */
    public function withModel(string|DedalusModel|array $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * Agent attributes. Values in [0.0, 1.0].
     *
     * @param array<string,float>|null $agentAttributes
     */
    public function withAgentAttributes(?array $agentAttributes): self
    {
        $self = clone $this;
        $self['agentAttributes'] = $agentAttributes;

        return $self;
    }

    /**
     * Parameters for audio output. Required when audio output is requested with
     * `modalities: ["audio"]`. [Learn more](/docs/guides/audio).
     *
     * Fields:
     * - voice (required): VoiceIdsOrCustomVoice
     * - format (required): Literal["wav", "aac", "mp3", "flac", "opus", "pcm16"]
     *
     * @param ChatCompletionAudioParam|ChatCompletionAudioParamShape|null $audio
     */
    public function withAudio(ChatCompletionAudioParam|array|null $audio): self
    {
        $self = clone $this;
        $self['audio'] = $audio;

        return $self;
    }

    /**
     * Execute tools server-side. If false, returns raw tool calls for manual handling.
     */
    public function withAutomaticToolExecution(
        bool $automaticToolExecution
    ): self {
        $self = clone $this;
        $self['automaticToolExecution'] = $automaticToolExecution;

        return $self;
    }

    /**
     * Optional. The name of the content [cached](https://ai.google.dev/gemini-api/docs/caching) to use as context to serve the prediction. Format: `cachedContents/{cachedContent}`.
     */
    public function withCachedContent(?string $cachedContent): self
    {
        $self = clone $this;
        $self['cachedContent'] = $cachedContent;

        return $self;
    }

    /**
     * Stable session ID for resuming a previous handoff. Returned by the server on handoff; echo it on the next request to resume.
     */
    public function withCorrelationID(?string $correlationID): self
    {
        $self = clone $this;
        $self['correlationID'] = $correlationID;

        return $self;
    }

    /**
     * Credentials for MCP server authentication. Each credential is matched to servers by connection name.
     *
     * @param CredentialsShape|null $credentials
     */
    public function withCredentials(Credential|array|null $credentials): self
    {
        $self = clone $this;
        $self['credentials'] = $credentials;

        return $self;
    }

    /**
     * If set to `true`, the request returns a `request_id`. You can then get the deferred response by GET `/v1/chat/deferred-completion/{request_id}`.
     */
    public function withDeferred(?bool $deferred): self
    {
        $self = clone $this;
        $self['deferred'] = $deferred;

        return $self;
    }

    /**
     * Tier 2 stateless resumption. Deferred tool specs from a previous handoff response, sent back verbatim so the server can resume without Redis.
     *
     * @param list<mixed>|null $deferredCalls
     */
    public function withDeferredCalls(?array $deferredCalls): self
    {
        $self = clone $this;
        $self['deferredCalls'] = $deferredCalls;

        return $self;
    }

    /**
     * Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.
     */
    public function withFrequencyPenalty(?float $frequencyPenalty): self
    {
        $self = clone $this;
        $self['frequencyPenalty'] = $frequencyPenalty;

        return $self;
    }

    /**
     * Deprecated in favor of `tool_choice`.  Controls which (if any) function is called by the model.  `none` means the model will not call a function and instead generates a message.  `auto` means the model can pick between generating a message or calling a function.  Specifying a particular function via `{"name": "my_function"}` forces the model to call that function.  `none` is the default when no functions are present. `auto` is the default if functions are present.
     */
    public function withFunctionCall(?string $functionCall): self
    {
        $self = clone $this;
        $self['functionCall'] = $functionCall;

        return $self;
    }

    /**
     * Deprecated in favor of `tools`.  A list of functions the model may generate JSON inputs for.
     *
     * @param list<ChatCompletionFunctions|ChatCompletionFunctionsShape>|null $functions
     */
    public function withFunctions(?array $functions): self
    {
        $self = clone $this;
        $self['functions'] = $functions;

        return $self;
    }

    /**
     * Generation parameters wrapper (Google-specific).
     *
     * @param array<string,mixed>|null $generationConfig
     */
    public function withGenerationConfig(?array $generationConfig): self
    {
        $self = clone $this;
        $self['generationConfig'] = $generationConfig;

        return $self;
    }

    /**
     * Content filtering and safety policy configuration.
     *
     * @param list<array<string,mixed>>|null $guardrails
     */
    public function withGuardrails(?array $guardrails): self
    {
        $self = clone $this;
        $self['guardrails'] = $guardrails;

        return $self;
    }

    /**
     * Configuration for multi-model handoffs.
     *
     * @param array<string,mixed>|null $handoffConfig
     */
    public function withHandoffConfig(?array $handoffConfig): self
    {
        $self = clone $this;
        $self['handoffConfig'] = $handoffConfig;

        return $self;
    }

    /**
     * Handoff control. None or omitted: auto-detect. true: structured handoff (SDK). false: drop-in (LLM re-run for mixed turns).
     */
    public function withHandoffMode(?bool $handoffMode): self
    {
        $self = clone $this;
        $self['handoffMode'] = $handoffMode;

        return $self;
    }

    /**
     * Specifies the geographic region for inference processing. If not specified, the workspace's `default_inference_geo` is used.
     */
    public function withInferenceGeo(?string $inferenceGeo): self
    {
        $self = clone $this;
        $self['inferenceGeo'] = $inferenceGeo;

        return $self;
    }

    /**
     * Modify the likelihood of specified tokens appearing in the completion.  Accepts a JSON object that maps tokens (specified by their token ID in the tokenizer) to an associated bias value from -100 to 100. Mathematically, the bias is added to the logits generated by the model prior to sampling. The exact effect will vary per model, but values between -1 and 1 should decrease or increase likelihood of selection; values like -100 or 100 should result in a ban or exclusive selection of the relevant token.
     *
     * @param array<string,int>|null $logitBias
     */
    public function withLogitBias(?array $logitBias): self
    {
        $self = clone $this;
        $self['logitBias'] = $logitBias;

        return $self;
    }

    /**
     * Whether to return log probabilities of the output tokens or not. If true, returns the log probabilities of each output token returned in the `content` of `message`.
     */
    public function withLogprobs(?bool $logprobs): self
    {
        $self = clone $this;
        $self['logprobs'] = $logprobs;

        return $self;
    }

    /**
     * Maximum tokens in completion (newer parameter name).
     */
    public function withMaxCompletionTokens(?int $maxCompletionTokens): self
    {
        $self = clone $this;
        $self['maxCompletionTokens'] = $maxCompletionTokens;

        return $self;
    }

    /**
     * Maximum tokens in completion.
     */
    public function withMaxTokens(?int $maxTokens): self
    {
        $self = clone $this;
        $self['maxTokens'] = $maxTokens;

        return $self;
    }

    /**
     * Maximum conversation turns.
     */
    public function withMaxTurns(?int $maxTurns): self
    {
        $self = clone $this;
        $self['maxTurns'] = $maxTurns;

        return $self;
    }

    /**
     * MCP server identifiers. Accepts marketplace slugs, URLs, or MCPServerSpec objects. MCP tools are executed server-side and billed separately.
     *
     * @param MCPServersShape|null $mcpServers
     */
    public function withMCPServers(
        string|MCPServerSpec|array|null $mcpServers
    ): self {
        $self = clone $this;
        $self['mcpServers'] = $mcpServers;

        return $self;
    }

    /**
     * Conversation history (OpenAI: messages, Google: contents, Responses: input).
     *
     * @param list<MessageShape>|null $messages
     */
    public function withMessages(?array $messages): self
    {
        $self = clone $this;
        $self['messages'] = $messages;

        return $self;
    }

    /**
     * Set of 16 key-value pairs that can be attached to an object. This can be useful for storing additional information about the object in a structured format, and querying for objects via API or the dashboard.  Keys are strings with a maximum length of 64 characters. Values are strings with a maximum length of 512 characters.
     *
     * @param array<string,mixed>|null $metadata
     */
    public function withMetadata(?array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Output types that you would like the model to generate. Most models are capable of generating text, which is the default:  `["text"]`  The `gpt-4o-audio-preview` model can also be used to [generate audio](/docs/guides/audio). To request that this model generate both text and audio responses, you can use:  `["text", "audio"]`.
     *
     * @param list<string>|null $modalities
     */
    public function withModalities(?array $modalities): self
    {
        $self = clone $this;
        $self['modalities'] = $modalities;

        return $self;
    }

    /**
     * Model attributes for routing. Maps model IDs to attribute dictionaries with values in [0.0, 1.0].
     *
     * @param array<string,array<string,float>>|null $modelAttributes
     */
    public function withModelAttributes(?array $modelAttributes): self
    {
        $self = clone $this;
        $self['modelAttributes'] = $modelAttributes;

        return $self;
    }

    /**
     * How many chat completion choices to generate for each input message. Note that you will be charged based on the number of generated tokens across all of the choices. Keep `n` as `1` to minimize costs.
     */
    public function withN(?int $n): self
    {
        $self = clone $this;
        $self['n'] = $n;

        return $self;
    }

    /**
     * @param array<string,mixed>|null $outputConfig
     */
    public function withOutputConfig(?array $outputConfig): self
    {
        $self = clone $this;
        $self['outputConfig'] = $outputConfig;

        return $self;
    }

    /**
     * Whether to enable parallel tool calls (Anthropic uses inverted polarity).
     */
    public function withParallelToolCalls(?bool $parallelToolCalls): self
    {
        $self = clone $this;
        $self['parallelToolCalls'] = $parallelToolCalls;

        return $self;
    }

    /**
     * Static predicted output content, such as the content of a text file that is
     * being regenerated.
     *
     * Fields:
     * - type (required): Literal["content"]
     * - content (required): str | Annotated[list[ChatCompletionRequestMessageContentPartText], MinLen(1), ArrayTitle("PredictionContentArray")]
     *
     * @param PredictionContent|PredictionContentShape|null $prediction
     */
    public function withPrediction(
        PredictionContent|array|null $prediction
    ): self {
        $self = clone $this;
        $self['prediction'] = $prediction;

        return $self;
    }

    /**
     * Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.
     */
    public function withPresencePenalty(?float $presencePenalty): self
    {
        $self = clone $this;
        $self['presencePenalty'] = $presencePenalty;

        return $self;
    }

    /**
     * Used by OpenAI to cache responses for similar requests to optimize your cache hit rates. Replaces the `user` field. [Learn more](/docs/guides/prompt-caching).
     */
    public function withPromptCacheKey(?string $promptCacheKey): self
    {
        $self = clone $this;
        $self['promptCacheKey'] = $promptCacheKey;

        return $self;
    }

    /**
     * The retention policy for the prompt cache. Set to `24h` to enable extended prompt caching, which keeps cached prefixes active for longer, up to a maximum of 24 hours. [Learn more](/docs/guides/prompt-caching#prompt-cache-retention).
     */
    public function withPromptCacheRetention(
        ?string $promptCacheRetention
    ): self {
        $self = clone $this;
        $self['promptCacheRetention'] = $promptCacheRetention;

        return $self;
    }

    /**
     * Allows toggling between the reasoning mode and no system prompt. When set to `reasoning` the system prompt for reasoning models will be used.
     *
     * @param PromptMode|value-of<PromptMode>|null $promptMode
     */
    public function withPromptMode(PromptMode|string|null $promptMode): self
    {
        $self = clone $this;
        $self['promptMode'] = $promptMode;

        return $self;
    }

    /**
     * Constrains effort on reasoning for [reasoning models](https://platform.openai.com/docs/guides/reasoning). Currently supported values are `none`, `minimal`, `low`, `medium`, `high`, and `xhigh`. Reducing reasoning effort can result in faster responses and fewer tokens used on reasoning in a response.  - `gpt-5.1` defaults to `none`, which does not perform reasoning. The supported reasoning values for `gpt-5.1` are `none`, `low`, `medium`, and `high`. Tool calls are supported for all reasoning values in gpt-5.1. - All models before `gpt-5.1` default to `medium` reasoning effort, and do not support `none`. - The `gpt-5-pro` model defaults to (and only supports) `high` reasoning effort. - `xhigh` is supported for all models after `gpt-5.1-codex-max`.
     */
    public function withReasoningEffort(?string $reasoningEffort): self
    {
        $self = clone $this;
        $self['reasoningEffort'] = $reasoningEffort;

        return $self;
    }

    /**
     * An object specifying the format that the model must output.  Setting to `{ "type": "json_schema", "json_schema": {...} }` enables Structured Outputs which ensures the model will match your supplied JSON schema. Learn more in the [Structured Outputs guide](/docs/guides/structured-outputs).  Setting to `{ "type": "json_object" }` enables the older JSON mode, which ensures the message the model generates is valid JSON. Using `json_schema` is preferred for models that support it.
     *
     * @param ResponseFormatShape|null $responseFormat
     */
    public function withResponseFormat(
        ResponseFormatText|array|ResponseFormatJSONSchema|ResponseFormatJSONObject|null $responseFormat,
    ): self {
        $self = clone $this;
        $self['responseFormat'] = $responseFormat;

        return $self;
    }

    /**
     * Whether to inject a safety prompt before all conversations.
     */
    public function withSafePrompt(?bool $safePrompt): self
    {
        $self = clone $this;
        $self['safePrompt'] = $safePrompt;

        return $self;
    }

    /**
     * A stable identifier used to help detect users of your application that may be violating OpenAI's usage policies. The IDs should be a string that uniquely identifies each user. We recommend hashing their username or email address, in order to avoid sending us any identifying information. [Learn more](/docs/guides/safety-best-practices#safety-identifiers).
     */
    public function withSafetyIdentifier(?string $safetyIdentifier): self
    {
        $self = clone $this;
        $self['safetyIdentifier'] = $safetyIdentifier;

        return $self;
    }

    /**
     * Safety/content filtering settings (Google-specific).
     *
     * @param list<SafetySetting|SafetySettingShape>|null $safetySettings
     */
    public function withSafetySettings(?array $safetySettings): self
    {
        $self = clone $this;
        $self['safetySettings'] = $safetySettings;

        return $self;
    }

    /**
     * Set the parameters to be used for searched data. If not set, no data will be acquired by the model.
     *
     * @param array<string,mixed>|null $searchParameters
     */
    public function withSearchParameters(?array $searchParameters): self
    {
        $self = clone $this;
        $self['searchParameters'] = $searchParameters;

        return $self;
    }

    /**
     * Random seed for deterministic output.
     */
    public function withSeed(?int $seed): self
    {
        $self = clone $this;
        $self['seed'] = $seed;

        return $self;
    }

    /**
     * Service tier for request processing.
     */
    public function withServiceTier(?string $serviceTier): self
    {
        $self = clone $this;
        $self['serviceTier'] = $serviceTier;

        return $self;
    }

    /**
     * The inference speed mode for this request. `"fast"` enables high output-tokens-per-second inference.
     *
     * @param Speed|value-of<Speed>|null $speed
     */
    public function withSpeed(Speed|string|null $speed): self
    {
        $self = clone $this;
        $self['speed'] = $speed;

        return $self;
    }

    /**
     * Sequences that stop generation.
     *
     * @param StopShape|null $stop
     */
    public function withStop(string|array|null $stop): self
    {
        $self = clone $this;
        $self['stop'] = $stop;

        return $self;
    }

    /**
     * Whether or not to store the output of this chat completion request for use in our [model distillation](/docs/guides/distillation) or [evals](/docs/guides/evals) products.  Supports text and image inputs. Note: image inputs over 8MB will be dropped.
     */
    public function withStore(?bool $store): self
    {
        $self = clone $this;
        $self['store'] = $store;

        return $self;
    }

    /**
     * Options for streaming response. Only set this when you set `stream: true`.
     *
     * @param array<string,mixed>|null $streamOptions
     */
    public function withStreamOptions(?array $streamOptions): self
    {
        $self = clone $this;
        $self['streamOptions'] = $streamOptions;

        return $self;
    }

    /**
     * System instruction/prompt.
     *
     * @param SystemInstructionShape|null $systemInstruction
     */
    public function withSystemInstruction(
        string|array|null $systemInstruction
    ): self {
        $self = clone $this;
        $self['systemInstruction'] = $systemInstruction;

        return $self;
    }

    /**
     * Sampling temperature (0-2 for most providers).
     */
    public function withTemperature(?float $temperature): self
    {
        $self = clone $this;
        $self['temperature'] = $temperature;

        return $self;
    }

    /**
     * Extended thinking configuration (Anthropic-specific).
     *
     * @param ThinkingShape|null $thinking
     */
    public function withThinking(
        ThinkingConfigEnabled|array|ThinkingConfigDisabled|ThinkingConfigAdaptive|null $thinking,
    ): self {
        $self = clone $this;
        $self['thinking'] = $thinking;

        return $self;
    }

    /**
     * Controls which (if any) tool is called by the model. `none` means the model will not call any tool and instead generates a message. `auto` means the model can pick between generating a message or calling one or more tools. `required` means the model must call one or more tools. Specifying a particular tool via `{"type": "function", "function": {"name": "my_function"}}` forces the model to call that tool.  `none` is the default when no tools are present. `auto` is the default if tools are present.
     *
     * @param ToolChoiceShape|null $toolChoice
     */
    public function withToolChoice(
        string|ToolChoiceAuto|array|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone|null $toolChoice,
    ): self {
        $self = clone $this;
        $self['toolChoice'] = $toolChoice;

        return $self;
    }

    /**
     * Tool calling configuration (Google-specific).
     *
     * @param array<string,mixed>|null $toolConfig
     */
    public function withToolConfig(?array $toolConfig): self
    {
        $self = clone $this;
        $self['toolConfig'] = $toolConfig;

        return $self;
    }

    /**
     * Available tools/functions for the model.
     *
     * @param list<ChatCompletionToolParam|ChatCompletionToolParamShape>|null $tools
     */
    public function withTools(?array $tools): self
    {
        $self = clone $this;
        $self['tools'] = $tools;

        return $self;
    }

    /**
     * Top-k sampling parameter.
     */
    public function withTopK(?int $topK): self
    {
        $self = clone $this;
        $self['topK'] = $topK;

        return $self;
    }

    /**
     * An integer between 0 and 20 specifying the number of most likely tokens to return at each token position, each with an associated log probability. `logprobs` must be set to `true` if this parameter is used.
     */
    public function withTopLogprobs(?int $topLogprobs): self
    {
        $self = clone $this;
        $self['topLogprobs'] = $topLogprobs;

        return $self;
    }

    /**
     * Nucleus sampling threshold.
     */
    public function withTopP(?float $topP): self
    {
        $self = clone $this;
        $self['topP'] = $topP;

        return $self;
    }

    /**
     * This field is being replaced by `safety_identifier` and `prompt_cache_key`. Use `prompt_cache_key` instead to maintain caching optimizations. A stable identifier for your end-users. Used to boost cache hit rates by better bucketing similar requests and  to help OpenAI detect and prevent abuse. [Learn more](/docs/guides/safety-best-practices#safety-identifiers).
     */
    public function withUser(?string $user): self
    {
        $self = clone $this;
        $self['user'] = $user;

        return $self;
    }

    /**
     * Constrains the verbosity of the model's response. Lower values will result in more concise responses, while higher values will result in more verbose responses. Currently supported values are `low`, `medium`, and `high`.
     */
    public function withVerbosity(?string $verbosity): self
    {
        $self = clone $this;
        $self['verbosity'] = $verbosity;

        return $self;
    }

    /**
     * This tool searches the web for relevant results to use in a response. Learn more about the [web search tool](/docs/guides/tools-web-search?api-mode=chat).
     *
     * @param array<string,mixed>|null $webSearchOptions
     */
    public function withWebSearchOptions(?array $webSearchOptions): self
    {
        $self = clone $this;
        $self['webSearchOptions'] = $webSearchOptions;

        return $self;
    }
}
