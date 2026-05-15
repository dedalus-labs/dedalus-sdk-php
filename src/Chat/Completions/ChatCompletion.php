<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Chat\Completions\ChatCompletion\MCPServerError;
use DedalusSDK\Chat\Completions\ChatCompletion\PendingTool;
use DedalusSDK\Chat\Completions\ChatCompletion\ServiceTier;
use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\Core\Conversion\MapOf;
use DedalusSDK\JSONValueInput;
use DedalusSDK\MCPToolResult;

/**
 * Chat completion response for Dedalus API.
 *
 * OpenAI-compatible chat completion response with Dedalus extensions.
 * Maintains full compatibility with OpenAI API while providing additional
 * features like server-side tool execution tracking and MCP error reporting.
 *
 * @phpstan-import-type ChoiceShape from \DedalusSDK\Chat\Completions\Choice
 * @phpstan-import-type MCPServerErrorShape from \DedalusSDK\Chat\Completions\ChatCompletion\MCPServerError
 * @phpstan-import-type CompletionUsageShape from \DedalusSDK\Chat\Completions\CompletionUsage
 *
 * @phpstan-type ChatCompletionShape = array{
 *   id: string,
 *   choices: list<Choice|ChoiceShape>,
 *   created: int,
 *   model: string,
 *   object: 'chat.completion',
 *   correlationID?: string|null,
 *   deferred?: list<mixed>|null,
 *   mcpServerErrors?: array<string,MCPServerError|MCPServerErrorShape>|null,
 *   mcpToolResults?: list<mixed>|null,
 *   pendingTools?: list<mixed>|null,
 *   serverResults?: array<string,mixed>|null,
 *   serviceTier?: null|ServiceTier|value-of<ServiceTier>,
 *   systemFingerprint?: string|null,
 *   toolsExecuted?: list<string>|null,
 *   turnsConsumed?: int|null,
 *   usage?: null|CompletionUsage|CompletionUsageShape,
 * }
 */
final class ChatCompletion implements BaseModel
{
    /** @use SdkModel<ChatCompletionShape> */
    use SdkModel;

    /**
     * The object type, which is always `chat.completion`.
     *
     * @var 'chat.completion' $object
     */
    #[Required]
    public string $object = 'chat.completion';

    /**
     * A unique identifier for the chat completion.
     */
    #[Required]
    public string $id;

    /**
     * A list of chat completion choices. Can be more than one if `n` is greater than 1.
     *
     * @var list<Choice> $choices
     */
    #[Required(list: Choice::class)]
    public array $choices;

    /**
     * The Unix timestamp (in seconds) of when the chat completion was created.
     */
    #[Required]
    public int $created;

    /**
     * The model used for the chat completion.
     */
    #[Required]
    public string $model;

    /**
     * Stable session ID for cross-turn handoff state. Echo this on the next request to resume server-side execution.
     */
    #[Optional('correlation_id', nullable: true)]
    public ?string $correlationID;

    /**
     * Server tools blocked on client results.
     *
     * @var list<mixed>|null $deferred
     */
    #[Optional(list: DeferredCallResponse::class, nullable: true)]
    public ?array $deferred;

    /**
     * MCP server failures keyed by server name.
     *
     * @var array<string,MCPServerError>|null $mcpServerErrors
     */
    #[Optional('mcp_server_errors', map: MCPServerError::class, nullable: true)]
    public ?array $mcpServerErrors;

    /**
     * Detailed results of MCP tool executions including inputs, outputs, and timing. Provides full visibility into server-side tool execution for debugging and audit purposes.
     *
     * @var list<mixed>|null $mcpToolResults
     */
    #[Optional('mcp_tool_results', list: MCPToolResult::class, nullable: true)]
    public ?array $mcpToolResults;

    /**
     * Client tools to execute, with dependency ordering.
     *
     * @var list<mixed>|null $pendingTools
     */
    #[Optional('pending_tools', list: PendingTool::class, nullable: true)]
    public ?array $pendingTools;

    /**
     * Completed server tool outputs keyed by call ID.
     *
     * @var array<string,mixed>|null $serverResults
     */
    #[Optional(
        'server_results',
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true,
    )]
    public ?array $serverResults;

    /**
     * Specifies the processing type used for serving the request.
     *   - If set to 'auto', then the request will be processed with the service tier configured in the Project settings. Unless otherwise configured, the Project will use 'default'.
     *   - If set to 'default', then the request will be processed with the standard pricing and performance for the selected model.
     *   - If set to '[flex](/docs/guides/flex-processing)' or '[priority](https://openai.com/api-priority-processing/)', then the request will be processed with the corresponding service tier.
     *   - When not set, the default behavior is 'auto'.
     *
     *   When the `service_tier` parameter is set, the response body will include the `service_tier` value based on the processing mode actually used to serve the request. This response value may be different from the value set in the parameter.
     *
     * @var value-of<ServiceTier>|null $serviceTier
     */
    #[Optional('service_tier', enum: ServiceTier::class, nullable: true)]
    public ?string $serviceTier;

    /**
     * This fingerprint represents the backend configuration that the model runs with.
     *
     * Can be used in conjunction with the `seed` request parameter to understand when backend changes have been made that might impact determinism.
     */
    #[Optional('system_fingerprint')]
    public ?string $systemFingerprint;

    /**
     * List of tool names that were executed server-side (e.g., MCP tools). Only present when tools were executed on the server rather than returned for client-side execution.
     *
     * @var list<string>|null $toolsExecuted
     */
    #[Optional('tools_executed', list: 'string', nullable: true)]
    public ?array $toolsExecuted;

    /**
     * Number of internal LLM calls made during this request. SDKs can sum this across their outer loop to track total LLM calls.
     */
    #[Optional('turns_consumed', nullable: true)]
    public ?int $turnsConsumed;

    /**
     * Usage statistics for the completion request.
     */
    #[Optional]
    public ?CompletionUsage $usage;

    /**
     * `new ChatCompletion()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChatCompletion::with(id: ..., choices: ..., created: ..., model: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChatCompletion)
     *   ->withID(...)
     *   ->withChoices(...)
     *   ->withCreated(...)
     *   ->withModel(...)
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
     * @param list<Choice|ChoiceShape> $choices
     * @param list<mixed>|null $deferred
     * @param array<string,MCPServerError|MCPServerErrorShape>|null $mcpServerErrors
     * @param list<mixed>|null $mcpToolResults
     * @param list<mixed>|null $pendingTools
     * @param array<string,mixed>|null $serverResults
     * @param ServiceTier|value-of<ServiceTier>|null $serviceTier
     * @param list<string>|null $toolsExecuted
     * @param CompletionUsage|CompletionUsageShape|null $usage
     */
    public static function with(
        string $id,
        array $choices,
        int $created,
        string $model,
        ?string $correlationID = null,
        ?array $deferred = null,
        ?array $mcpServerErrors = null,
        ?array $mcpToolResults = null,
        ?array $pendingTools = null,
        ?array $serverResults = null,
        ServiceTier|string|null $serviceTier = null,
        ?string $systemFingerprint = null,
        ?array $toolsExecuted = null,
        ?int $turnsConsumed = null,
        CompletionUsage|array|null $usage = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['choices'] = $choices;
        $self['created'] = $created;
        $self['model'] = $model;

        null !== $correlationID && $self['correlationID'] = $correlationID;
        null !== $deferred && $self['deferred'] = $deferred;
        null !== $mcpServerErrors && $self['mcpServerErrors'] = $mcpServerErrors;
        null !== $mcpToolResults && $self['mcpToolResults'] = $mcpToolResults;
        null !== $pendingTools && $self['pendingTools'] = $pendingTools;
        null !== $serverResults && $self['serverResults'] = $serverResults;
        null !== $serviceTier && $self['serviceTier'] = $serviceTier;
        null !== $systemFingerprint && $self['systemFingerprint'] = $systemFingerprint;
        null !== $toolsExecuted && $self['toolsExecuted'] = $toolsExecuted;
        null !== $turnsConsumed && $self['turnsConsumed'] = $turnsConsumed;
        null !== $usage && $self['usage'] = $usage;

        return $self;
    }

    /**
     * A unique identifier for the chat completion.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * A list of chat completion choices. Can be more than one if `n` is greater than 1.
     *
     * @param list<Choice|ChoiceShape> $choices
     */
    public function withChoices(array $choices): self
    {
        $self = clone $this;
        $self['choices'] = $choices;

        return $self;
    }

    /**
     * The Unix timestamp (in seconds) of when the chat completion was created.
     */
    public function withCreated(int $created): self
    {
        $self = clone $this;
        $self['created'] = $created;

        return $self;
    }

    /**
     * The model used for the chat completion.
     */
    public function withModel(string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * The object type, which is always `chat.completion`.
     *
     * @param 'chat.completion' $object
     */
    public function withObject(string $object): self
    {
        $self = clone $this;
        $self['object'] = $object;

        return $self;
    }

    /**
     * Stable session ID for cross-turn handoff state. Echo this on the next request to resume server-side execution.
     */
    public function withCorrelationID(?string $correlationID): self
    {
        $self = clone $this;
        $self['correlationID'] = $correlationID;

        return $self;
    }

    /**
     * Server tools blocked on client results.
     *
     * @param list<mixed>|null $deferred
     */
    public function withDeferred(?array $deferred): self
    {
        $self = clone $this;
        $self['deferred'] = $deferred;

        return $self;
    }

    /**
     * MCP server failures keyed by server name.
     *
     * @param array<string,MCPServerError|MCPServerErrorShape>|null $mcpServerErrors
     */
    public function withMCPServerErrors(?array $mcpServerErrors): self
    {
        $self = clone $this;
        $self['mcpServerErrors'] = $mcpServerErrors;

        return $self;
    }

    /**
     * Detailed results of MCP tool executions including inputs, outputs, and timing. Provides full visibility into server-side tool execution for debugging and audit purposes.
     *
     * @param list<mixed>|null $mcpToolResults
     */
    public function withMCPToolResults(?array $mcpToolResults): self
    {
        $self = clone $this;
        $self['mcpToolResults'] = $mcpToolResults;

        return $self;
    }

    /**
     * Client tools to execute, with dependency ordering.
     *
     * @param list<mixed>|null $pendingTools
     */
    public function withPendingTools(?array $pendingTools): self
    {
        $self = clone $this;
        $self['pendingTools'] = $pendingTools;

        return $self;
    }

    /**
     * Completed server tool outputs keyed by call ID.
     *
     * @param array<string,mixed>|null $serverResults
     */
    public function withServerResults(?array $serverResults): self
    {
        $self = clone $this;
        $self['serverResults'] = $serverResults;

        return $self;
    }

    /**
     * Specifies the processing type used for serving the request.
     *   - If set to 'auto', then the request will be processed with the service tier configured in the Project settings. Unless otherwise configured, the Project will use 'default'.
     *   - If set to 'default', then the request will be processed with the standard pricing and performance for the selected model.
     *   - If set to '[flex](/docs/guides/flex-processing)' or '[priority](https://openai.com/api-priority-processing/)', then the request will be processed with the corresponding service tier.
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
     * This fingerprint represents the backend configuration that the model runs with.
     *
     * Can be used in conjunction with the `seed` request parameter to understand when backend changes have been made that might impact determinism.
     */
    public function withSystemFingerprint(string $systemFingerprint): self
    {
        $self = clone $this;
        $self['systemFingerprint'] = $systemFingerprint;

        return $self;
    }

    /**
     * List of tool names that were executed server-side (e.g., MCP tools). Only present when tools were executed on the server rather than returned for client-side execution.
     *
     * @param list<string>|null $toolsExecuted
     */
    public function withToolsExecuted(?array $toolsExecuted): self
    {
        $self = clone $this;
        $self['toolsExecuted'] = $toolsExecuted;

        return $self;
    }

    /**
     * Number of internal LLM calls made during this request. SDKs can sum this across their outer loop to track total LLM calls.
     */
    public function withTurnsConsumed(?int $turnsConsumed): self
    {
        $self = clone $this;
        $self['turnsConsumed'] = $turnsConsumed;

        return $self;
    }

    /**
     * Usage statistics for the completion request.
     *
     * @param CompletionUsage|CompletionUsageShape $usage
     */
    public function withUsage(CompletionUsage|array $usage): self
    {
        $self = clone $this;
        $self['usage'] = $usage;

        return $self;
    }
}
