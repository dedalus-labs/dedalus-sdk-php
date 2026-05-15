<?php

declare(strict_types=1);

namespace DedalusSDK\Responses;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Concerns\SdkParams;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\Core\Conversion\MapOf;
use DedalusSDK\Credential;
use DedalusSDK\DedalusModel;
use DedalusSDK\JSONValueInput;
use DedalusSDK\MCPServerSpec;
use DedalusSDK\Responses\ResponseCreateParams1\Conversation\ResponseConversationParam;
use DedalusSDK\Responses\ResponseCreateParams1\Credentials;
use DedalusSDK\Responses\ResponseCreateParams1\Input;
use DedalusSDK\Responses\ResponseCreateParams1\Instructions;
use DedalusSDK\Responses\ResponseCreateParams1\MCPServers;
use DedalusSDK\Responses\ResponseCreateParams1\Model;
use DedalusSDK\Responses\ResponseCreateParams1\Prompt;
use DedalusSDK\Responses\ResponseCreateParams1\ServiceTier;
use DedalusSDK\Responses\ResponseCreateParams1\ToolChoice;
use DedalusSDK\Responses\ResponseCreateParams1\Truncation;

/**
 * Create a response using the OpenAI Responses API.
 *
 * This endpoint routes directly to OpenAI's Responses API.
 * Only OpenAI models are supported.
 *
 * @see DedalusSDK\Services\ResponsesService::create()
 *
 * @phpstan-import-type ConversationVariants from \DedalusSDK\Responses\ResponseCreateParams1\Conversation
 * @phpstan-import-type CredentialsVariants from \DedalusSDK\Responses\ResponseCreateParams1\Credentials
 * @phpstan-import-type InputVariants from \DedalusSDK\Responses\ResponseCreateParams1\Input
 * @phpstan-import-type InstructionsVariants from \DedalusSDK\Responses\ResponseCreateParams1\Instructions
 * @phpstan-import-type MCPServersVariants from \DedalusSDK\Responses\ResponseCreateParams1\MCPServers
 * @phpstan-import-type ModelVariants from \DedalusSDK\Responses\ResponseCreateParams1\Model
 * @phpstan-import-type ToolChoiceVariants from \DedalusSDK\Responses\ResponseCreateParams1\ToolChoice
 * @phpstan-import-type ConversationShape from \DedalusSDK\Responses\ResponseCreateParams1\Conversation
 * @phpstan-import-type CredentialsShape from \DedalusSDK\Responses\ResponseCreateParams1\Credentials
 * @phpstan-import-type InputShape from \DedalusSDK\Responses\ResponseCreateParams1\Input
 * @phpstan-import-type InstructionsShape from \DedalusSDK\Responses\ResponseCreateParams1\Instructions
 * @phpstan-import-type MCPServersShape from \DedalusSDK\Responses\ResponseCreateParams1\MCPServers
 * @phpstan-import-type ModelShape from \DedalusSDK\Responses\ResponseCreateParams1\Model
 * @phpstan-import-type PromptShape from \DedalusSDK\Responses\ResponseCreateParams1\Prompt
 * @phpstan-import-type ToolChoiceShape from \DedalusSDK\Responses\ResponseCreateParams1\ToolChoice
 *
 * @phpstan-type ResponseCreateParams1Shape = array{
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
 *   prompt?: null|Prompt|PromptShape,
 *   promptCacheKey?: string|null,
 *   reasoning?: array<string,mixed>|null,
 *   safetyIdentifier?: string|null,
 *   serviceTier?: null|ServiceTier|value-of<ServiceTier>,
 *   store?: bool|null,
 *   stream?: bool|null,
 *   streamOptions?: array<string,mixed>|null,
 *   temperature?: float|null,
 *   text?: array<string,mixed>|null,
 *   toolChoice?: ToolChoiceShape|null,
 *   tools?: list<mixed>|null,
 *   topLogprobs?: int|null,
 *   topP?: float|null,
 *   truncation?: null|Truncation|value-of<Truncation>,
 *   user?: string|null,
 * }
 */
final class ResponseCreateParams1 implements BaseModel
{
    /** @use SdkModel<ResponseCreateParams1Shape> */
    use SdkModel;
    use SdkParams;

    /**
     * Whether to run the model response in the background.
     * [Learn more](https://platform.openai.com/docs/guides/background).
     */
    #[Optional(nullable: true)]
    public ?bool $background;

    /**
     * Conversation that this response belongs to. Items from this conversation are prepended to the input items, and output items from this response are automatically added after completion.
     *
     * @var ConversationVariants|null $conversation
     */
    #[Optional(nullable: true)]
    public string|ResponseConversationParam|null $conversation;

    /**
     * Credentials for MCP server authentication. Each credential is matched to servers by connection name.
     *
     * @var CredentialsVariants|null $credentials
     */
    #[Optional(union: Credentials::class, nullable: true)]
    public Credential|array|null $credentials;

    /**
     * Penalizes new tokens based on their frequency in the text so far.
     */
    #[Optional('frequency_penalty', nullable: true)]
    public ?float $frequencyPenalty;

    /**
     * Specify additional output data to include in the model response. Currently
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
     *
     * @var list<string>|null $include
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $include;

    /**
     * Text, image, or file inputs to the model, used to generate a response.
     *
     * Learn more:
     * - [Text inputs and outputs](https://platform.openai.com/docs/guides/text)
     * - [Image inputs](https://platform.openai.com/docs/guides/images)
     * - [File inputs](https://platform.openai.com/docs/guides/pdf-files)
     * - [Conversation state](https://platform.openai.com/docs/guides/conversation-state)
     * - [Function calling](https://platform.openai.com/docs/guides/function-calling)
     *
     * @var InputVariants|null $input
     */
    #[Optional(union: Input::class, nullable: true)]
    public string|array|null $input;

    /**
     * A system (or developer) message inserted into the model's context.
     *
     * When using along with `previous_response_id`, the instructions from a previous
     * response will not be carried over to the next response. This makes it simple
     * to swap out system (or developer) messages in new responses.
     *
     * @var InstructionsVariants|null $instructions
     */
    #[Optional(union: Instructions::class, nullable: true)]
    public string|array|null $instructions;

    /**
     * An upper bound for the number of tokens that can be generated for a response, including visible output tokens and [reasoning tokens](https://platform.openai.com/docs/guides/reasoning).
     */
    #[Optional('max_output_tokens', nullable: true)]
    public ?int $maxOutputTokens;

    /**
     * The maximum number of total calls to built-in tools that can be processed in a response. This maximum number applies across all built-in tool calls, not per individual tool. Any further attempts to call a tool by the model will be ignored.
     */
    #[Optional('max_tool_calls', nullable: true)]
    public ?int $maxToolCalls;

    /**
     * MCP server identifiers. Accepts marketplace slugs, URLs, or MCPServerSpec objects. MCP tools are executed server-side and billed separately.
     *
     * @var MCPServersVariants|null $mcpServers
     */
    #[Optional('mcp_servers', union: MCPServers::class, nullable: true)]
    public string|MCPServerSpec|array|null $mcpServers;

    /**
     * Set of up to 16 key-value string pairs that can be attached to the response for structured metadata and later querying via the API or dashboard.
     *
     * @var array<string,string>|null $metadata
     */
    #[Optional(map: 'string', nullable: true)]
    public ?array $metadata;

    /**
     * Model ID used to generate the response, like `gpt-4o` or `o3`. OpenAI
     * offers a wide range of models with different capabilities, performance
     * characteristics, and price points. Refer to the [model guide](https://platform.openai.com/docs/models)
     * to browse and compare available models.
     *
     * @var ModelVariants|null $model
     */
    #[Optional(union: Model::class, nullable: true)]
    public string|DedalusModel|array|null $model;

    /**
     * Whether to allow the model to run tool calls in parallel.
     */
    #[Optional('parallel_tool_calls', nullable: true)]
    public ?bool $parallelToolCalls;

    /**
     * Penalizes new tokens based on whether they appear in the text so far.
     */
    #[Optional('presence_penalty', nullable: true)]
    public ?float $presencePenalty;

    /**
     * Unique ID of the previous response to continue from when creating multi-turn conversations. Cannot be used together with `conversation`.
     */
    #[Optional('previous_response_id', nullable: true)]
    public ?string $previousResponseID;

    /**
     * Stored prompt template reference (BYOK).
     */
    #[Optional(nullable: true)]
    public ?Prompt $prompt;

    /**
     * Used by OpenAI to cache responses for similar requests to optimize your cache hit rates. Replaces the `user` field. [Learn more](https://platform.openai.com/docs/guides/prompt-caching).
     */
    #[Optional('prompt_cache_key', nullable: true)]
    public ?string $promptCacheKey;

    /**
     * **gpt-5 and o-series models only**.
     *
     * Configuration options for
     * [reasoning models](https://platform.openai.com/docs/guides/reasoning).
     *
     * @var array<string,mixed>|null $reasoning
     */
    #[Optional(
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true
    )]
    public ?array $reasoning;

    /**
     * A stable identifier used to help detect users of your application that may be violating OpenAI's usage policies.
     * The IDs should be a string that uniquely identifies each user. We recommend hashing their username or email address, in order to avoid sending us any identifying information. [Learn more](https://platform.openai.com/docs/guides/safety-best-practices#safety-identifiers).
     */
    #[Optional('safety_identifier', nullable: true)]
    public ?string $safetyIdentifier;

    /**
     * Specifies the processing type used for serving the request.
     *   - If set to 'auto', then the request will be processed with the service tier configured in the Project settings. Unless otherwise configured, the Project will use 'default'.
     *   - If set to 'default', then the request will be processed with the standard pricing and performance for the selected model.
     *   - If set to '[flex](https://platform.openai.com/docs/guides/flex-processing)' or '[priority](https://openai.com/api-priority-processing/)', then the request will be processed with the corresponding service tier.
     *   - When not set, the default behavior is 'auto'.
     *
     *   When the `service_tier` parameter is set, the response body will include the `service_tier` value based on the processing mode actually used to serve the request. This response value may be different from the value set in the parameter.
     *
     * @var value-of<ServiceTier>|null $serviceTier
     */
    #[Optional('service_tier', enum: ServiceTier::class, nullable: true)]
    public ?string $serviceTier;

    /**
     * Whether to store the generated response for later retrieval via the Responses API.
     */
    #[Optional(nullable: true)]
    public ?bool $store;

    /**
     * If set to true, the model response data will be streamed to the client
     * as it is generated using [server-sent events](https://developer.mozilla.org/en-US/docs/Web/API/Server-sent_events/Using_server-sent_events#Event_stream_format).
     * See the [Streaming section below](https://platform.openai.com/docs/api-reference/responses-streaming)
     * for more information.
     */
    #[Optional]
    public ?bool $stream;

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
     * What sampling temperature to use, between 0 and 2. Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic.
     * We generally recommend altering this or `top_p` but not both.
     */
    #[Optional(nullable: true)]
    public ?float $temperature;

    /**
     * Configuration options for a text response from the model. Can be plain
     * text or structured JSON data. Learn more:
     * - [Text inputs and outputs](https://platform.openai.com/docs/guides/text)
     * - [Structured Outputs](https://platform.openai.com/docs/guides/structured-outputs).
     *
     * @var array<string,mixed>|null $text
     */
    #[Optional(
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true
    )]
    public ?array $text;

    /**
     * How the model should select which tool (or tools) to use when generating
     * a response. See the `tools` parameter to see how to specify which tools
     * the model can call.
     *
     * @var ToolChoiceVariants|null $toolChoice
     */
    #[Optional('tool_choice', union: ToolChoice::class, nullable: true)]
    public string|array|null $toolChoice;

    /**
     * An array of tools the model may call while generating a response. You
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
     *
     * @var list<mixed>|null $tools
     */
    #[Optional(
        list: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true
    )]
    public ?array $tools;

    /**
     * An integer between 0 and 20 specifying the number of most likely tokens to
     * return at each token position, each with an associated log probability.
     */
    #[Optional('top_logprobs', nullable: true)]
    public ?int $topLogprobs;

    /**
     * An alternative to sampling with temperature, called nucleus sampling,
     * where the model considers the results of the tokens with top_p probability
     * mass. So 0.1 means only the tokens comprising the top 10% probability mass
     * are considered.
     *
     * We generally recommend altering this or `temperature` but not both.
     */
    #[Optional('top_p', nullable: true)]
    public ?float $topP;

    /**
     * The truncation strategy to use for the model response.
     * - `auto`: If the input to this Response exceeds
     *   the model's context window size, the model will truncate the
     *   response to fit the context window by dropping items from the beginning of the conversation.
     * - `disabled` (default): If the input size will exceed the context window
     *   size for a model, the request will fail with a 400 error.
     *
     * @var value-of<Truncation>|null $truncation
     */
    #[Optional(enum: Truncation::class, nullable: true)]
    public ?string $truncation;

    /**
     * This field is being replaced by `safety_identifier` and `prompt_cache_key`. Use `prompt_cache_key` instead to maintain caching optimizations.
     * A stable identifier for your end-users.
     * Used to boost cache hit rates by better bucketing similar requests and  to help OpenAI detect and prevent abuse. [Learn more](https://platform.openai.com/docs/guides/safety-best-practices#safety-identifiers).
     */
    #[Optional(nullable: true)]
    public ?string $user;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ConversationShape|null $conversation
     * @param CredentialsShape|null $credentials
     * @param list<string>|null $include
     * @param InputShape|null $input
     * @param InstructionsShape|null $instructions
     * @param MCPServersShape|null $mcpServers
     * @param array<string,string>|null $metadata
     * @param ModelShape|null $model
     * @param Prompt|PromptShape|null $prompt
     * @param array<string,mixed>|null $reasoning
     * @param ServiceTier|value-of<ServiceTier>|null $serviceTier
     * @param array<string,mixed>|null $streamOptions
     * @param array<string,mixed>|null $text
     * @param ToolChoiceShape|null $toolChoice
     * @param list<mixed>|null $tools
     * @param Truncation|value-of<Truncation>|null $truncation
     */
    public static function with(
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
        ?bool $stream = null,
        ?array $streamOptions = null,
        ?float $temperature = null,
        ?array $text = null,
        string|array|null $toolChoice = null,
        ?array $tools = null,
        ?int $topLogprobs = null,
        ?float $topP = null,
        Truncation|string|null $truncation = null,
        ?string $user = null,
    ): self {
        $self = new self;

        null !== $background && $self['background'] = $background;
        null !== $conversation && $self['conversation'] = $conversation;
        null !== $credentials && $self['credentials'] = $credentials;
        null !== $frequencyPenalty && $self['frequencyPenalty'] = $frequencyPenalty;
        null !== $include && $self['include'] = $include;
        null !== $input && $self['input'] = $input;
        null !== $instructions && $self['instructions'] = $instructions;
        null !== $maxOutputTokens && $self['maxOutputTokens'] = $maxOutputTokens;
        null !== $maxToolCalls && $self['maxToolCalls'] = $maxToolCalls;
        null !== $mcpServers && $self['mcpServers'] = $mcpServers;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $model && $self['model'] = $model;
        null !== $parallelToolCalls && $self['parallelToolCalls'] = $parallelToolCalls;
        null !== $presencePenalty && $self['presencePenalty'] = $presencePenalty;
        null !== $previousResponseID && $self['previousResponseID'] = $previousResponseID;
        null !== $prompt && $self['prompt'] = $prompt;
        null !== $promptCacheKey && $self['promptCacheKey'] = $promptCacheKey;
        null !== $reasoning && $self['reasoning'] = $reasoning;
        null !== $safetyIdentifier && $self['safetyIdentifier'] = $safetyIdentifier;
        null !== $serviceTier && $self['serviceTier'] = $serviceTier;
        null !== $store && $self['store'] = $store;
        null !== $stream && $self['stream'] = $stream;
        null !== $streamOptions && $self['streamOptions'] = $streamOptions;
        null !== $temperature && $self['temperature'] = $temperature;
        null !== $text && $self['text'] = $text;
        null !== $toolChoice && $self['toolChoice'] = $toolChoice;
        null !== $tools && $self['tools'] = $tools;
        null !== $topLogprobs && $self['topLogprobs'] = $topLogprobs;
        null !== $topP && $self['topP'] = $topP;
        null !== $truncation && $self['truncation'] = $truncation;
        null !== $user && $self['user'] = $user;

        return $self;
    }

    /**
     * Whether to run the model response in the background.
     * [Learn more](https://platform.openai.com/docs/guides/background).
     */
    public function withBackground(?bool $background): self
    {
        $self = clone $this;
        $self['background'] = $background;

        return $self;
    }

    /**
     * Conversation that this response belongs to. Items from this conversation are prepended to the input items, and output items from this response are automatically added after completion.
     *
     * @param ConversationShape|null $conversation
     */
    public function withConversation(
        string|ResponseConversationParam|array|null $conversation
    ): self {
        $self = clone $this;
        $self['conversation'] = $conversation;

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
     * Penalizes new tokens based on their frequency in the text so far.
     */
    public function withFrequencyPenalty(?float $frequencyPenalty): self
    {
        $self = clone $this;
        $self['frequencyPenalty'] = $frequencyPenalty;

        return $self;
    }

    /**
     * Specify additional output data to include in the model response. Currently
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
     *
     * @param list<string>|null $include
     */
    public function withInclude(?array $include): self
    {
        $self = clone $this;
        $self['include'] = $include;

        return $self;
    }

    /**
     * Text, image, or file inputs to the model, used to generate a response.
     *
     * Learn more:
     * - [Text inputs and outputs](https://platform.openai.com/docs/guides/text)
     * - [Image inputs](https://platform.openai.com/docs/guides/images)
     * - [File inputs](https://platform.openai.com/docs/guides/pdf-files)
     * - [Conversation state](https://platform.openai.com/docs/guides/conversation-state)
     * - [Function calling](https://platform.openai.com/docs/guides/function-calling)
     *
     * @param InputShape|null $input
     */
    public function withInput(string|array|null $input): self
    {
        $self = clone $this;
        $self['input'] = $input;

        return $self;
    }

    /**
     * A system (or developer) message inserted into the model's context.
     *
     * When using along with `previous_response_id`, the instructions from a previous
     * response will not be carried over to the next response. This makes it simple
     * to swap out system (or developer) messages in new responses.
     *
     * @param InstructionsShape|null $instructions
     */
    public function withInstructions(string|array|null $instructions): self
    {
        $self = clone $this;
        $self['instructions'] = $instructions;

        return $self;
    }

    /**
     * An upper bound for the number of tokens that can be generated for a response, including visible output tokens and [reasoning tokens](https://platform.openai.com/docs/guides/reasoning).
     */
    public function withMaxOutputTokens(?int $maxOutputTokens): self
    {
        $self = clone $this;
        $self['maxOutputTokens'] = $maxOutputTokens;

        return $self;
    }

    /**
     * The maximum number of total calls to built-in tools that can be processed in a response. This maximum number applies across all built-in tool calls, not per individual tool. Any further attempts to call a tool by the model will be ignored.
     */
    public function withMaxToolCalls(?int $maxToolCalls): self
    {
        $self = clone $this;
        $self['maxToolCalls'] = $maxToolCalls;

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
     * Set of up to 16 key-value string pairs that can be attached to the response for structured metadata and later querying via the API or dashboard.
     *
     * @param array<string,string>|null $metadata
     */
    public function withMetadata(?array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Model ID used to generate the response, like `gpt-4o` or `o3`. OpenAI
     * offers a wide range of models with different capabilities, performance
     * characteristics, and price points. Refer to the [model guide](https://platform.openai.com/docs/models)
     * to browse and compare available models.
     *
     * @param ModelShape|null $model
     */
    public function withModel(string|DedalusModel|array|null $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * Whether to allow the model to run tool calls in parallel.
     */
    public function withParallelToolCalls(?bool $parallelToolCalls): self
    {
        $self = clone $this;
        $self['parallelToolCalls'] = $parallelToolCalls;

        return $self;
    }

    /**
     * Penalizes new tokens based on whether they appear in the text so far.
     */
    public function withPresencePenalty(?float $presencePenalty): self
    {
        $self = clone $this;
        $self['presencePenalty'] = $presencePenalty;

        return $self;
    }

    /**
     * Unique ID of the previous response to continue from when creating multi-turn conversations. Cannot be used together with `conversation`.
     */
    public function withPreviousResponseID(?string $previousResponseID): self
    {
        $self = clone $this;
        $self['previousResponseID'] = $previousResponseID;

        return $self;
    }

    /**
     * Stored prompt template reference (BYOK).
     *
     * @param Prompt|PromptShape|null $prompt
     */
    public function withPrompt(Prompt|array|null $prompt): self
    {
        $self = clone $this;
        $self['prompt'] = $prompt;

        return $self;
    }

    /**
     * Used by OpenAI to cache responses for similar requests to optimize your cache hit rates. Replaces the `user` field. [Learn more](https://platform.openai.com/docs/guides/prompt-caching).
     */
    public function withPromptCacheKey(?string $promptCacheKey): self
    {
        $self = clone $this;
        $self['promptCacheKey'] = $promptCacheKey;

        return $self;
    }

    /**
     * **gpt-5 and o-series models only**.
     *
     * Configuration options for
     * [reasoning models](https://platform.openai.com/docs/guides/reasoning).
     *
     * @param array<string,mixed>|null $reasoning
     */
    public function withReasoning(?array $reasoning): self
    {
        $self = clone $this;
        $self['reasoning'] = $reasoning;

        return $self;
    }

    /**
     * A stable identifier used to help detect users of your application that may be violating OpenAI's usage policies.
     * The IDs should be a string that uniquely identifies each user. We recommend hashing their username or email address, in order to avoid sending us any identifying information. [Learn more](https://platform.openai.com/docs/guides/safety-best-practices#safety-identifiers).
     */
    public function withSafetyIdentifier(?string $safetyIdentifier): self
    {
        $self = clone $this;
        $self['safetyIdentifier'] = $safetyIdentifier;

        return $self;
    }

    /**
     * Specifies the processing type used for serving the request.
     *   - If set to 'auto', then the request will be processed with the service tier configured in the Project settings. Unless otherwise configured, the Project will use 'default'.
     *   - If set to 'default', then the request will be processed with the standard pricing and performance for the selected model.
     *   - If set to '[flex](https://platform.openai.com/docs/guides/flex-processing)' or '[priority](https://openai.com/api-priority-processing/)', then the request will be processed with the corresponding service tier.
     *   - When not set, the default behavior is 'auto'.
     *
     *   When the `service_tier` parameter is set, the response body will include the `service_tier` value based on the processing mode actually used to serve the request. This response value may be different from the value set in the parameter.
     *
     * @param ServiceTier|value-of<ServiceTier>|null $serviceTier
     */
    public function withServiceTier(ServiceTier|string|null $serviceTier): self
    {
        $self = clone $this;
        $self['serviceTier'] = $serviceTier;

        return $self;
    }

    /**
     * Whether to store the generated response for later retrieval via the Responses API.
     */
    public function withStore(?bool $store): self
    {
        $self = clone $this;
        $self['store'] = $store;

        return $self;
    }

    /**
     * If set to true, the model response data will be streamed to the client
     * as it is generated using [server-sent events](https://developer.mozilla.org/en-US/docs/Web/API/Server-sent_events/Using_server-sent_events#Event_stream_format).
     * See the [Streaming section below](https://platform.openai.com/docs/api-reference/responses-streaming)
     * for more information.
     */
    public function withStream(bool $stream): self
    {
        $self = clone $this;
        $self['stream'] = $stream;

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
     * What sampling temperature to use, between 0 and 2. Higher values like 0.8 will make the output more random, while lower values like 0.2 will make it more focused and deterministic.
     * We generally recommend altering this or `top_p` but not both.
     */
    public function withTemperature(?float $temperature): self
    {
        $self = clone $this;
        $self['temperature'] = $temperature;

        return $self;
    }

    /**
     * Configuration options for a text response from the model. Can be plain
     * text or structured JSON data. Learn more:
     * - [Text inputs and outputs](https://platform.openai.com/docs/guides/text)
     * - [Structured Outputs](https://platform.openai.com/docs/guides/structured-outputs).
     *
     * @param array<string,mixed>|null $text
     */
    public function withText(?array $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * How the model should select which tool (or tools) to use when generating
     * a response. See the `tools` parameter to see how to specify which tools
     * the model can call.
     *
     * @param ToolChoiceShape|null $toolChoice
     */
    public function withToolChoice(string|array|null $toolChoice): self
    {
        $self = clone $this;
        $self['toolChoice'] = $toolChoice;

        return $self;
    }

    /**
     * An array of tools the model may call while generating a response. You
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
     *
     * @param list<mixed>|null $tools
     */
    public function withTools(?array $tools): self
    {
        $self = clone $this;
        $self['tools'] = $tools;

        return $self;
    }

    /**
     * An integer between 0 and 20 specifying the number of most likely tokens to
     * return at each token position, each with an associated log probability.
     */
    public function withTopLogprobs(?int $topLogprobs): self
    {
        $self = clone $this;
        $self['topLogprobs'] = $topLogprobs;

        return $self;
    }

    /**
     * An alternative to sampling with temperature, called nucleus sampling,
     * where the model considers the results of the tokens with top_p probability
     * mass. So 0.1 means only the tokens comprising the top 10% probability mass
     * are considered.
     *
     * We generally recommend altering this or `temperature` but not both.
     */
    public function withTopP(?float $topP): self
    {
        $self = clone $this;
        $self['topP'] = $topP;

        return $self;
    }

    /**
     * The truncation strategy to use for the model response.
     * - `auto`: If the input to this Response exceeds
     *   the model's context window size, the model will truncate the
     *   response to fit the context window by dropping items from the beginning of the conversation.
     * - `disabled` (default): If the input size will exceed the context window
     *   size for a model, the request will fail with a 400 error.
     *
     * @param Truncation|value-of<Truncation>|null $truncation
     */
    public function withTruncation(Truncation|string|null $truncation): self
    {
        $self = clone $this;
        $self['truncation'] = $truncation;

        return $self;
    }

    /**
     * This field is being replaced by `safety_identifier` and `prompt_cache_key`. Use `prompt_cache_key` instead to maintain caching optimizations.
     * A stable identifier for your end-users.
     * Used to boost cache hit rates by better bucketing similar requests and  to help OpenAI detect and prevent abuse. [Learn more](https://platform.openai.com/docs/guides/safety-best-practices#safety-identifiers).
     */
    public function withUser(?string $user): self
    {
        $self = clone $this;
        $self['user'] = $user;

        return $self;
    }
}
