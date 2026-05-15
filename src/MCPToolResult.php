<?php

declare(strict_types=1);

namespace DedalusSDK;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\Core\Conversion\MapOf;

/**
 * Result of a single MCP tool execution.
 *
 * Provides visibility into MCP tool calls including the full input arguments
 * and structured output, enabling debugging and audit trails.
 *
 * @phpstan-import-type JSONValueInputVariants from \DedalusSDK\JSONValueInput
 * @phpstan-import-type JSONValueInputShape from \DedalusSDK\JSONValueInput
 *
 * @phpstan-type MCPToolResultShape = array{
 *   arguments: array<string,mixed>,
 *   isError: bool,
 *   serverName: string,
 *   toolName: string,
 *   durationMs?: int|null,
 *   result?: JSONValueInputShape|null,
 * }
 */
final class MCPToolResult implements BaseModel
{
    /** @use SdkModel<MCPToolResultShape> */
    use SdkModel;

    /**
     * Input arguments passed to the tool.
     *
     * @var array<string,mixed> $arguments
     */
    #[Required(type: new MapOf(JSONValueInput::class, nullable: true))]
    public array $arguments;

    /**
     * Whether the tool execution resulted in an error.
     */
    #[Required('is_error')]
    public bool $isError;

    /**
     * Name of the MCP server that handled the tool.
     */
    #[Required('server_name')]
    public string $serverName;

    /**
     * Name of the MCP tool that was executed.
     */
    #[Required('tool_name')]
    public string $toolName;

    /**
     * Execution time in milliseconds.
     */
    #[Optional('duration_ms', nullable: true)]
    public ?int $durationMs;

    /**
     * Structured result from the tool (parsed from structuredContent or content).
     *
     * @var JSONValueInputVariants|null $result
     */
    #[Optional(union: JSONValueInput::class, nullable: true)]
    public string|float|bool|array|null $result;

    /**
     * `new MCPToolResult()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MCPToolResult::with(
     *   arguments: ..., isError: ..., serverName: ..., toolName: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MCPToolResult)
     *   ->withArguments(...)
     *   ->withIsError(...)
     *   ->withServerName(...)
     *   ->withToolName(...)
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
     * @param array<string,mixed> $arguments
     * @param JSONValueInputShape|null $result
     */
    public static function with(
        array $arguments,
        bool $isError,
        string $serverName,
        string $toolName,
        ?int $durationMs = null,
        string|float|bool|array|null $result = null,
    ): self {
        $self = new self;

        $self['arguments'] = $arguments;
        $self['isError'] = $isError;
        $self['serverName'] = $serverName;
        $self['toolName'] = $toolName;

        null !== $durationMs && $self['durationMs'] = $durationMs;
        null !== $result && $self['result'] = $result;

        return $self;
    }

    /**
     * Input arguments passed to the tool.
     *
     * @param array<string,mixed> $arguments
     */
    public function withArguments(array $arguments): self
    {
        $self = clone $this;
        $self['arguments'] = $arguments;

        return $self;
    }

    /**
     * Whether the tool execution resulted in an error.
     */
    public function withIsError(bool $isError): self
    {
        $self = clone $this;
        $self['isError'] = $isError;

        return $self;
    }

    /**
     * Name of the MCP server that handled the tool.
     */
    public function withServerName(string $serverName): self
    {
        $self = clone $this;
        $self['serverName'] = $serverName;

        return $self;
    }

    /**
     * Name of the MCP tool that was executed.
     */
    public function withToolName(string $toolName): self
    {
        $self = clone $this;
        $self['toolName'] = $toolName;

        return $self;
    }

    /**
     * Execution time in milliseconds.
     */
    public function withDurationMs(?int $durationMs): self
    {
        $self = clone $this;
        $self['durationMs'] = $durationMs;

        return $self;
    }

    /**
     * Structured result from the tool (parsed from structuredContent or content).
     *
     * @param JSONValueInputShape|null $result
     */
    public function withResult(string|float|bool|array|null $result): self
    {
        $self = clone $this;
        $self['result'] = $result;

        return $self;
    }
}
