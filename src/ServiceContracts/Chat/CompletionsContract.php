<?php

declare(strict_types=1);

namespace DedalusSDK\ServiceContracts\Chat;

use DedalusSDK\Chat\Completions\ChatCompletion;
use DedalusSDK\Chat\Completions\ChatCompletionAudioParam;
use DedalusSDK\Chat\Completions\ChatCompletionChunk;
use DedalusSDK\Chat\Completions\ChatCompletionFunctions;
use DedalusSDK\Chat\Completions\ChatCompletionToolParam;
use DedalusSDK\Chat\Completions\CompletionCreateParams\PromptMode;
use DedalusSDK\Chat\Completions\CompletionCreateParams\SafetySetting;
use DedalusSDK\Chat\Completions\CompletionCreateParams\Speed;
use DedalusSDK\Chat\Completions\CompletionCreateParams\Thinking\ThinkingConfigAdaptive;
use DedalusSDK\Chat\Completions\PredictionContent;
use DedalusSDK\Chat\Completions\ThinkingConfigDisabled;
use DedalusSDK\Chat\Completions\ThinkingConfigEnabled;
use DedalusSDK\Chat\Completions\ToolChoiceAny;
use DedalusSDK\Chat\Completions\ToolChoiceAuto;
use DedalusSDK\Chat\Completions\ToolChoiceNone;
use DedalusSDK\Chat\Completions\ToolChoiceTool;
use DedalusSDK\Core\Contracts\BaseStream;
use DedalusSDK\Core\Exceptions\APIException;
use DedalusSDK\Credential;
use DedalusSDK\DedalusModel;
use DedalusSDK\MCPServerSpec;
use DedalusSDK\RequestOptions;
use DedalusSDK\ResponseFormatJSONObject;
use DedalusSDK\ResponseFormatJSONSchema;
use DedalusSDK\ResponseFormatText;

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
interface CompletionsContract
{
    /**
     * @api
     *
     * @param ModelShape $model Model identifier. Accepts model ID strings, lists for routing, or DedalusModel objects with per-model settings.
     * @param array<string,float>|null $agentAttributes Agent attributes. Values in [0.0, 1.0].
     * @param ChatCompletionAudioParam|ChatCompletionAudioParamShape|null $audio Parameters for audio output. Required when audio output is requested with
     * `modalities: ["audio"]`. [Learn more](/docs/guides/audio).
     *
     * Fields:
     * - voice (required): VoiceIdsOrCustomVoice
     * - format (required): Literal["wav", "aac", "mp3", "flac", "opus", "pcm16"]
     * @param bool $automaticToolExecution Execute tools server-side. If false, returns raw tool calls for manual handling.
     * @param string|null $cachedContent Optional. The name of the content [cached](https://ai.google.dev/gemini-api/docs/caching) to use as context to serve the prediction. Format: `cachedContents/{cachedContent}`
     * @param string|null $correlationID Stable session ID for resuming a previous handoff. Returned by the server on handoff; echo it on the next request to resume.
     * @param CredentialsShape|null $credentials Credentials for MCP server authentication. Each credential is matched to servers by connection name.
     * @param bool|null $deferred If set to `true`, the request returns a `request_id`. You can then get the deferred response by GET `/v1/chat/deferred-completion/{request_id}`.
     * @param list<mixed>|null $deferredCalls Tier 2 stateless resumption. Deferred tool specs from a previous handoff response, sent back verbatim so the server can resume without Redis.
     * @param float|null $frequencyPenalty Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.
     * @param string|null $functionCall Deprecated in favor of `tool_choice`.  Controls which (if any) function is called by the model.  `none` means the model will not call a function and instead generates a message.  `auto` means the model can pick between generating a message or calling a function.  Specifying a particular function via `{"name": "my_function"}` forces the model to call that function.  `none` is the default when no functions are present. `auto` is the default if functions are present.
     * @param list<ChatCompletionFunctions|ChatCompletionFunctionsShape>|null $functions Deprecated in favor of `tools`.  A list of functions the model may generate JSON inputs for.
     * @param array<string,mixed>|null $generationConfig Generation parameters wrapper (Google-specific)
     * @param list<array<string,mixed>>|null $guardrails content filtering and safety policy configuration
     * @param array<string,mixed>|null $handoffConfig configuration for multi-model handoffs
     * @param bool|null $handoffMode Handoff control. None or omitted: auto-detect. true: structured handoff (SDK). false: drop-in (LLM re-run for mixed turns).
     * @param string|null $inferenceGeo Specifies the geographic region for inference processing. If not specified, the workspace's `default_inference_geo` is used.
     * @param array<string,int>|null $logitBias Modify the likelihood of specified tokens appearing in the completion.  Accepts a JSON object that maps tokens (specified by their token ID in the tokenizer) to an associated bias value from -100 to 100. Mathematically, the bias is added to the logits generated by the model prior to sampling. The exact effect will vary per model, but values between -1 and 1 should decrease or increase likelihood of selection; values like -100 or 100 should result in a ban or exclusive selection of the relevant token.
     * @param bool|null $logprobs Whether to return log probabilities of the output tokens or not. If true, returns the log probabilities of each output token returned in the `content` of `message`.
     * @param int|null $maxCompletionTokens Maximum tokens in completion (newer parameter name)
     * @param int|null $maxTokens Maximum tokens in completion
     * @param int|null $maxTurns maximum conversation turns
     * @param MCPServersShape|null $mcpServers MCP server identifiers. Accepts marketplace slugs, URLs, or MCPServerSpec objects. MCP tools are executed server-side and billed separately.
     * @param list<MessageShape>|null $messages Conversation history (OpenAI: messages, Google: contents, Responses: input)
     * @param array<string,mixed>|null $metadata Set of 16 key-value pairs that can be attached to an object. This can be useful for storing additional information about the object in a structured format, and querying for objects via API or the dashboard.  Keys are strings with a maximum length of 64 characters. Values are strings with a maximum length of 512 characters.
     * @param list<string>|null $modalities Output types that you would like the model to generate. Most models are capable of generating text, which is the default:  `["text"]`  The `gpt-4o-audio-preview` model can also be used to [generate audio](/docs/guides/audio). To request that this model generate both text and audio responses, you can use:  `["text", "audio"]`
     * @param array<string,array<string,float>>|null $modelAttributes Model attributes for routing. Maps model IDs to attribute dictionaries with values in [0.0, 1.0].
     * @param int|null $n How many chat completion choices to generate for each input message. Note that you will be charged based on the number of generated tokens across all of the choices. Keep `n` as `1` to minimize costs.
     * @param array<string,mixed>|null $outputConfig
     * @param bool|null $parallelToolCalls whether to enable parallel tool calls (Anthropic uses inverted polarity)
     * @param PredictionContent|PredictionContentShape|null $prediction Static predicted output content, such as the content of a text file that is
     * being regenerated.
     *
     * Fields:
     * - type (required): Literal["content"]
     * - content (required): str | Annotated[list[ChatCompletionRequestMessageContentPartText], MinLen(1), ArrayTitle("PredictionContentArray")]
     * @param float|null $presencePenalty Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.
     * @param string|null $promptCacheKey Used by OpenAI to cache responses for similar requests to optimize your cache hit rates. Replaces the `user` field. [Learn more](/docs/guides/prompt-caching).
     * @param string|null $promptCacheRetention The retention policy for the prompt cache. Set to `24h` to enable extended prompt caching, which keeps cached prefixes active for longer, up to a maximum of 24 hours. [Learn more](/docs/guides/prompt-caching#prompt-cache-retention).
     * @param PromptMode|value-of<PromptMode>|null $promptMode Allows toggling between the reasoning mode and no system prompt. When set to `reasoning` the system prompt for reasoning models will be used.
     * @param string|null $reasoningEffort Constrains effort on reasoning for [reasoning models](https://platform.openai.com/docs/guides/reasoning). Currently supported values are `none`, `minimal`, `low`, `medium`, `high`, and `xhigh`. Reducing reasoning effort can result in faster responses and fewer tokens used on reasoning in a response.  - `gpt-5.1` defaults to `none`, which does not perform reasoning. The supported reasoning values for `gpt-5.1` are `none`, `low`, `medium`, and `high`. Tool calls are supported for all reasoning values in gpt-5.1. - All models before `gpt-5.1` default to `medium` reasoning effort, and do not support `none`. - The `gpt-5-pro` model defaults to (and only supports) `high` reasoning effort. - `xhigh` is supported for all models after `gpt-5.1-codex-max`.
     * @param ResponseFormatShape|null $responseFormat An object specifying the format that the model must output.  Setting to `{ "type": "json_schema", "json_schema": {...} }` enables Structured Outputs which ensures the model will match your supplied JSON schema. Learn more in the [Structured Outputs guide](/docs/guides/structured-outputs).  Setting to `{ "type": "json_object" }` enables the older JSON mode, which ensures the message the model generates is valid JSON. Using `json_schema` is preferred for models that support it.
     * @param bool|null $safePrompt whether to inject a safety prompt before all conversations
     * @param string|null $safetyIdentifier A stable identifier used to help detect users of your application that may be violating OpenAI's usage policies. The IDs should be a string that uniquely identifies each user. We recommend hashing their username or email address, in order to avoid sending us any identifying information. [Learn more](/docs/guides/safety-best-practices#safety-identifiers).
     * @param list<SafetySetting|SafetySettingShape>|null $safetySettings Safety/content filtering settings (Google-specific)
     * @param array<string,mixed>|null $searchParameters Set the parameters to be used for searched data. If not set, no data will be acquired by the model.
     * @param int|null $seed Random seed for deterministic output
     * @param string|null $serviceTier Service tier for request processing
     * @param Speed|value-of<Speed>|null $speed The inference speed mode for this request. `"fast"` enables high output-tokens-per-second inference.
     * @param StopShape|null $stop Sequences that stop generation
     * @param bool|null $store Whether or not to store the output of this chat completion request for use in our [model distillation](/docs/guides/distillation) or [evals](/docs/guides/evals) products.  Supports text and image inputs. Note: image inputs over 8MB will be dropped.
     * @param array<string,mixed>|null $streamOptions Options for streaming response. Only set this when you set `stream: true`.
     * @param SystemInstructionShape|null $systemInstruction System instruction/prompt
     * @param float|null $temperature Sampling temperature (0-2 for most providers)
     * @param ThinkingShape|null $thinking Extended thinking configuration (Anthropic-specific)
     * @param ToolChoiceShape|null $toolChoice Controls which (if any) tool is called by the model. `none` means the model will not call any tool and instead generates a message. `auto` means the model can pick between generating a message or calling one or more tools. `required` means the model must call one or more tools. Specifying a particular tool via `{"type": "function", "function": {"name": "my_function"}}` forces the model to call that tool.  `none` is the default when no tools are present. `auto` is the default if tools are present.
     * @param array<string,mixed>|null $toolConfig Tool calling configuration (Google-specific)
     * @param list<ChatCompletionToolParam|ChatCompletionToolParamShape>|null $tools Available tools/functions for the model
     * @param int|null $topK Top-k sampling parameter
     * @param int|null $topLogprobs An integer between 0 and 20 specifying the number of most likely tokens to return at each token position, each with an associated log probability. `logprobs` must be set to `true` if this parameter is used.
     * @param float|null $topP Nucleus sampling threshold
     * @param string|null $user This field is being replaced by `safety_identifier` and `prompt_cache_key`. Use `prompt_cache_key` instead to maintain caching optimizations. A stable identifier for your end-users. Used to boost cache hit rates by better bucketing similar requests and  to help OpenAI detect and prevent abuse. [Learn more](/docs/guides/safety-best-practices#safety-identifiers).
     * @param string|null $verbosity Constrains the verbosity of the model's response. Lower values will result in more concise responses, while higher values will result in more verbose responses. Currently supported values are `low`, `medium`, and `high`.
     * @param array<string,mixed>|null $webSearchOptions This tool searches the web for relevant results to use in a response. Learn more about the [web search tool](/docs/guides/tools-web-search?api-mode=chat).
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string|DedalusModel|array $model,
        ?array $agentAttributes = null,
        ChatCompletionAudioParam|array|null $audio = null,
        bool $automaticToolExecution = true,
        ?string $cachedContent = null,
        ?string $correlationID = null,
        Credential|array|null $credentials = null,
        ?bool $deferred = false,
        ?array $deferredCalls = null,
        ?float $frequencyPenalty = 0,
        ?string $functionCall = null,
        ?array $functions = null,
        ?array $generationConfig = null,
        ?array $guardrails = null,
        ?array $handoffConfig = null,
        ?bool $handoffMode = null,
        ?string $inferenceGeo = null,
        ?array $logitBias = null,
        ?bool $logprobs = false,
        ?int $maxCompletionTokens = null,
        ?int $maxTokens = null,
        ?int $maxTurns = null,
        string|MCPServerSpec|array|null $mcpServers = null,
        ?array $messages = null,
        ?array $metadata = null,
        ?array $modalities = null,
        ?array $modelAttributes = null,
        ?int $n = 1,
        ?array $outputConfig = null,
        ?bool $parallelToolCalls = true,
        PredictionContent|array|null $prediction = null,
        ?float $presencePenalty = 0,
        ?string $promptCacheKey = null,
        ?string $promptCacheRetention = null,
        PromptMode|string|null $promptMode = null,
        ?string $reasoningEffort = 'medium',
        ResponseFormatText|array|ResponseFormatJSONSchema|ResponseFormatJSONObject|null $responseFormat = null,
        ?bool $safePrompt = false,
        ?string $safetyIdentifier = null,
        ?array $safetySettings = null,
        ?array $searchParameters = null,
        ?int $seed = null,
        ?string $serviceTier = 'auto',
        Speed|string|null $speed = null,
        string|array|null $stop = null,
        ?bool $store = false,
        ?array $streamOptions = null,
        string|array|null $systemInstruction = null,
        ?float $temperature = 1,
        ThinkingConfigEnabled|array|ThinkingConfigDisabled|ThinkingConfigAdaptive|null $thinking = null,
        string|ToolChoiceAuto|array|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone|null $toolChoice = 'auto',
        ?array $toolConfig = null,
        ?array $tools = null,
        ?int $topK = null,
        ?int $topLogprobs = null,
        ?float $topP = 1,
        ?string $user = null,
        ?string $verbosity = 'medium',
        ?array $webSearchOptions = null,
        RequestOptions|array|null $requestOptions = null,
    ): ChatCompletion;

    /**
     * @api
     *
     * @param ModelShape $model Model identifier. Accepts model ID strings, lists for routing, or DedalusModel objects with per-model settings.
     * @param array<string,float>|null $agentAttributes Agent attributes. Values in [0.0, 1.0].
     * @param ChatCompletionAudioParam|ChatCompletionAudioParamShape|null $audio Parameters for audio output. Required when audio output is requested with
     * `modalities: ["audio"]`. [Learn more](/docs/guides/audio).
     *
     * Fields:
     * - voice (required): VoiceIdsOrCustomVoice
     * - format (required): Literal["wav", "aac", "mp3", "flac", "opus", "pcm16"]
     * @param bool $automaticToolExecution Execute tools server-side. If false, returns raw tool calls for manual handling.
     * @param string|null $cachedContent Optional. The name of the content [cached](https://ai.google.dev/gemini-api/docs/caching) to use as context to serve the prediction. Format: `cachedContents/{cachedContent}`
     * @param string|null $correlationID Stable session ID for resuming a previous handoff. Returned by the server on handoff; echo it on the next request to resume.
     * @param CredentialsShape|null $credentials Credentials for MCP server authentication. Each credential is matched to servers by connection name.
     * @param bool|null $deferred If set to `true`, the request returns a `request_id`. You can then get the deferred response by GET `/v1/chat/deferred-completion/{request_id}`.
     * @param list<mixed>|null $deferredCalls Tier 2 stateless resumption. Deferred tool specs from a previous handoff response, sent back verbatim so the server can resume without Redis.
     * @param float|null $frequencyPenalty Number between -2.0 and 2.0. Positive values penalize new tokens based on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line verbatim.
     * @param string|null $functionCall Deprecated in favor of `tool_choice`.  Controls which (if any) function is called by the model.  `none` means the model will not call a function and instead generates a message.  `auto` means the model can pick between generating a message or calling a function.  Specifying a particular function via `{"name": "my_function"}` forces the model to call that function.  `none` is the default when no functions are present. `auto` is the default if functions are present.
     * @param list<ChatCompletionFunctions|ChatCompletionFunctionsShape>|null $functions Deprecated in favor of `tools`.  A list of functions the model may generate JSON inputs for.
     * @param array<string,mixed>|null $generationConfig Generation parameters wrapper (Google-specific)
     * @param list<array<string,mixed>>|null $guardrails content filtering and safety policy configuration
     * @param array<string,mixed>|null $handoffConfig configuration for multi-model handoffs
     * @param bool|null $handoffMode Handoff control. None or omitted: auto-detect. true: structured handoff (SDK). false: drop-in (LLM re-run for mixed turns).
     * @param string|null $inferenceGeo Specifies the geographic region for inference processing. If not specified, the workspace's `default_inference_geo` is used.
     * @param array<string,int>|null $logitBias Modify the likelihood of specified tokens appearing in the completion.  Accepts a JSON object that maps tokens (specified by their token ID in the tokenizer) to an associated bias value from -100 to 100. Mathematically, the bias is added to the logits generated by the model prior to sampling. The exact effect will vary per model, but values between -1 and 1 should decrease or increase likelihood of selection; values like -100 or 100 should result in a ban or exclusive selection of the relevant token.
     * @param bool|null $logprobs Whether to return log probabilities of the output tokens or not. If true, returns the log probabilities of each output token returned in the `content` of `message`.
     * @param int|null $maxCompletionTokens Maximum tokens in completion (newer parameter name)
     * @param int|null $maxTokens Maximum tokens in completion
     * @param int|null $maxTurns maximum conversation turns
     * @param MCPServersShape|null $mcpServers MCP server identifiers. Accepts marketplace slugs, URLs, or MCPServerSpec objects. MCP tools are executed server-side and billed separately.
     * @param list<MessageShape>|null $messages Conversation history (OpenAI: messages, Google: contents, Responses: input)
     * @param array<string,mixed>|null $metadata Set of 16 key-value pairs that can be attached to an object. This can be useful for storing additional information about the object in a structured format, and querying for objects via API or the dashboard.  Keys are strings with a maximum length of 64 characters. Values are strings with a maximum length of 512 characters.
     * @param list<string>|null $modalities Output types that you would like the model to generate. Most models are capable of generating text, which is the default:  `["text"]`  The `gpt-4o-audio-preview` model can also be used to [generate audio](/docs/guides/audio). To request that this model generate both text and audio responses, you can use:  `["text", "audio"]`
     * @param array<string,array<string,float>>|null $modelAttributes Model attributes for routing. Maps model IDs to attribute dictionaries with values in [0.0, 1.0].
     * @param int|null $n How many chat completion choices to generate for each input message. Note that you will be charged based on the number of generated tokens across all of the choices. Keep `n` as `1` to minimize costs.
     * @param array<string,mixed>|null $outputConfig
     * @param bool|null $parallelToolCalls whether to enable parallel tool calls (Anthropic uses inverted polarity)
     * @param PredictionContent|PredictionContentShape|null $prediction Static predicted output content, such as the content of a text file that is
     * being regenerated.
     *
     * Fields:
     * - type (required): Literal["content"]
     * - content (required): str | Annotated[list[ChatCompletionRequestMessageContentPartText], MinLen(1), ArrayTitle("PredictionContentArray")]
     * @param float|null $presencePenalty Number between -2.0 and 2.0. Positive values penalize new tokens based on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.
     * @param string|null $promptCacheKey Used by OpenAI to cache responses for similar requests to optimize your cache hit rates. Replaces the `user` field. [Learn more](/docs/guides/prompt-caching).
     * @param string|null $promptCacheRetention The retention policy for the prompt cache. Set to `24h` to enable extended prompt caching, which keeps cached prefixes active for longer, up to a maximum of 24 hours. [Learn more](/docs/guides/prompt-caching#prompt-cache-retention).
     * @param PromptMode|value-of<PromptMode>|null $promptMode Allows toggling between the reasoning mode and no system prompt. When set to `reasoning` the system prompt for reasoning models will be used.
     * @param string|null $reasoningEffort Constrains effort on reasoning for [reasoning models](https://platform.openai.com/docs/guides/reasoning). Currently supported values are `none`, `minimal`, `low`, `medium`, `high`, and `xhigh`. Reducing reasoning effort can result in faster responses and fewer tokens used on reasoning in a response.  - `gpt-5.1` defaults to `none`, which does not perform reasoning. The supported reasoning values for `gpt-5.1` are `none`, `low`, `medium`, and `high`. Tool calls are supported for all reasoning values in gpt-5.1. - All models before `gpt-5.1` default to `medium` reasoning effort, and do not support `none`. - The `gpt-5-pro` model defaults to (and only supports) `high` reasoning effort. - `xhigh` is supported for all models after `gpt-5.1-codex-max`.
     * @param ResponseFormatShape|null $responseFormat An object specifying the format that the model must output.  Setting to `{ "type": "json_schema", "json_schema": {...} }` enables Structured Outputs which ensures the model will match your supplied JSON schema. Learn more in the [Structured Outputs guide](/docs/guides/structured-outputs).  Setting to `{ "type": "json_object" }` enables the older JSON mode, which ensures the message the model generates is valid JSON. Using `json_schema` is preferred for models that support it.
     * @param bool|null $safePrompt whether to inject a safety prompt before all conversations
     * @param string|null $safetyIdentifier A stable identifier used to help detect users of your application that may be violating OpenAI's usage policies. The IDs should be a string that uniquely identifies each user. We recommend hashing their username or email address, in order to avoid sending us any identifying information. [Learn more](/docs/guides/safety-best-practices#safety-identifiers).
     * @param list<SafetySetting|SafetySettingShape>|null $safetySettings Safety/content filtering settings (Google-specific)
     * @param array<string,mixed>|null $searchParameters Set the parameters to be used for searched data. If not set, no data will be acquired by the model.
     * @param int|null $seed Random seed for deterministic output
     * @param string|null $serviceTier Service tier for request processing
     * @param Speed|value-of<Speed>|null $speed The inference speed mode for this request. `"fast"` enables high output-tokens-per-second inference.
     * @param StopShape|null $stop Sequences that stop generation
     * @param bool|null $store Whether or not to store the output of this chat completion request for use in our [model distillation](/docs/guides/distillation) or [evals](/docs/guides/evals) products.  Supports text and image inputs. Note: image inputs over 8MB will be dropped.
     * @param array<string,mixed>|null $streamOptions Options for streaming response. Only set this when you set `stream: true`.
     * @param SystemInstructionShape|null $systemInstruction System instruction/prompt
     * @param float|null $temperature Sampling temperature (0-2 for most providers)
     * @param ThinkingShape|null $thinking Extended thinking configuration (Anthropic-specific)
     * @param ToolChoiceShape|null $toolChoice Controls which (if any) tool is called by the model. `none` means the model will not call any tool and instead generates a message. `auto` means the model can pick between generating a message or calling one or more tools. `required` means the model must call one or more tools. Specifying a particular tool via `{"type": "function", "function": {"name": "my_function"}}` forces the model to call that tool.  `none` is the default when no tools are present. `auto` is the default if tools are present.
     * @param array<string,mixed>|null $toolConfig Tool calling configuration (Google-specific)
     * @param list<ChatCompletionToolParam|ChatCompletionToolParamShape>|null $tools Available tools/functions for the model
     * @param int|null $topK Top-k sampling parameter
     * @param int|null $topLogprobs An integer between 0 and 20 specifying the number of most likely tokens to return at each token position, each with an associated log probability. `logprobs` must be set to `true` if this parameter is used.
     * @param float|null $topP Nucleus sampling threshold
     * @param string|null $user This field is being replaced by `safety_identifier` and `prompt_cache_key`. Use `prompt_cache_key` instead to maintain caching optimizations. A stable identifier for your end-users. Used to boost cache hit rates by better bucketing similar requests and  to help OpenAI detect and prevent abuse. [Learn more](/docs/guides/safety-best-practices#safety-identifiers).
     * @param string|null $verbosity Constrains the verbosity of the model's response. Lower values will result in more concise responses, while higher values will result in more verbose responses. Currently supported values are `low`, `medium`, and `high`.
     * @param array<string,mixed>|null $webSearchOptions This tool searches the web for relevant results to use in a response. Learn more about the [web search tool](/docs/guides/tools-web-search?api-mode=chat).
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseStream<ChatCompletionChunk>
     *
     * @throws APIException
     */
    public function createStream(
        string|DedalusModel|array $model,
        ?array $agentAttributes = null,
        ChatCompletionAudioParam|array|null $audio = null,
        bool $automaticToolExecution = true,
        ?string $cachedContent = null,
        ?string $correlationID = null,
        Credential|array|null $credentials = null,
        ?bool $deferred = false,
        ?array $deferredCalls = null,
        ?float $frequencyPenalty = 0,
        ?string $functionCall = null,
        ?array $functions = null,
        ?array $generationConfig = null,
        ?array $guardrails = null,
        ?array $handoffConfig = null,
        ?bool $handoffMode = null,
        ?string $inferenceGeo = null,
        ?array $logitBias = null,
        ?bool $logprobs = false,
        ?int $maxCompletionTokens = null,
        ?int $maxTokens = null,
        ?int $maxTurns = null,
        string|MCPServerSpec|array|null $mcpServers = null,
        ?array $messages = null,
        ?array $metadata = null,
        ?array $modalities = null,
        ?array $modelAttributes = null,
        ?int $n = 1,
        ?array $outputConfig = null,
        ?bool $parallelToolCalls = true,
        PredictionContent|array|null $prediction = null,
        ?float $presencePenalty = 0,
        ?string $promptCacheKey = null,
        ?string $promptCacheRetention = null,
        PromptMode|string|null $promptMode = null,
        ?string $reasoningEffort = 'medium',
        ResponseFormatText|array|ResponseFormatJSONSchema|ResponseFormatJSONObject|null $responseFormat = null,
        ?bool $safePrompt = false,
        ?string $safetyIdentifier = null,
        ?array $safetySettings = null,
        ?array $searchParameters = null,
        ?int $seed = null,
        ?string $serviceTier = 'auto',
        Speed|string|null $speed = null,
        string|array|null $stop = null,
        ?bool $store = false,
        ?array $streamOptions = null,
        string|array|null $systemInstruction = null,
        ?float $temperature = 1,
        ThinkingConfigEnabled|array|ThinkingConfigDisabled|ThinkingConfigAdaptive|null $thinking = null,
        string|ToolChoiceAuto|array|ToolChoiceAny|ToolChoiceTool|ToolChoiceNone|null $toolChoice = 'auto',
        ?array $toolConfig = null,
        ?array $tools = null,
        ?int $topK = null,
        ?int $topLogprobs = null,
        ?float $topP = 1,
        ?string $user = null,
        ?string $verbosity = 'medium',
        ?array $webSearchOptions = null,
        RequestOptions|array|null $requestOptions = null,
    ): BaseStream;
}
