<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletion;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\Core\Conversion\MapOf;
use DedalusSDK\JSONValueInput;

/**
 * Client-side tool call the SDK must execute.
 *
 * @phpstan-type PendingToolShape = array{
 *   id: string,
 *   arguments: array<string,mixed>,
 *   name: string,
 *   dependencies?: list<string>|null,
 * }
 */
final class PendingTool implements BaseModel
{
    /** @use SdkModel<PendingToolShape> */
    use SdkModel;

    /**
     * Unique identifier for this tool call.
     */
    #[Required]
    public string $id;

    /**
     * Input arguments for the tool call.
     *
     * @var array<string,mixed> $arguments
     */
    #[Required(type: new MapOf(JSONValueInput::class, nullable: true))]
    public array $arguments;

    /**
     * Name of the tool to execute.
     */
    #[Required]
    public string $name;

    /**
     * IDs of other pending calls that must complete first.
     *
     * @var list<string>|null $dependencies
     */
    #[Optional(list: 'string')]
    public ?array $dependencies;

    /**
     * `new PendingTool()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PendingTool::with(id: ..., arguments: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PendingTool)->withID(...)->withArguments(...)->withName(...)
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
     * @param list<string>|null $dependencies
     */
    public static function with(
        string $id,
        array $arguments,
        string $name,
        ?array $dependencies = null
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['arguments'] = $arguments;
        $self['name'] = $name;

        null !== $dependencies && $self['dependencies'] = $dependencies;

        return $self;
    }

    /**
     * Unique identifier for this tool call.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Input arguments for the tool call.
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
     * Name of the tool to execute.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * IDs of other pending calls that must complete first.
     *
     * @param list<string> $dependencies
     */
    public function withDependencies(array $dependencies): self
    {
        $self = clone $this;
        $self['dependencies'] = $dependencies;

        return $self;
    }
}
