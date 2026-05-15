<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\Core\Conversion\MapOf;
use DedalusSDK\JSONValueInput;

/**
 * Server-side call blocked until pending client calls complete.
 *
 * Carries full spec for stateless resumption on subsequent turns.
 *
 * @phpstan-type DeferredCallResponseShape = array{
 *   id: string,
 *   name: string,
 *   arguments?: array<string,mixed>|null,
 *   blockedBy?: list<string>|null,
 *   dependencies?: list<string>|null,
 *   venue?: string|null,
 * }
 */
final class DeferredCallResponse implements BaseModel
{
    /** @use SdkModel<DeferredCallResponseShape> */
    use SdkModel;

    /**
     * Unique identifier for this deferred call.
     */
    #[Required]
    public string $id;

    /**
     * Name of the tool.
     */
    #[Required]
    public string $name;

    /**
     * Input arguments for the tool call.
     *
     * @var array<string,mixed>|null $arguments
     */
    #[Optional(type: new MapOf(JSONValueInput::class, nullable: true))]
    public ?array $arguments;

    /**
     * IDs of pending client calls blocking this call.
     *
     * @var list<string>|null $blockedBy
     */
    #[Optional('blocked_by', list: 'string')]
    public ?array $blockedBy;

    /**
     * IDs of calls this depends on.
     *
     * @var list<string>|null $dependencies
     */
    #[Optional(list: 'string')]
    public ?array $dependencies;

    /**
     * Execution venue (server or client).
     */
    #[Optional]
    public ?string $venue;

    /**
     * `new DeferredCallResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DeferredCallResponse::with(id: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DeferredCallResponse)->withID(...)->withName(...)
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
     * @param array<string,mixed>|null $arguments
     * @param list<string>|null $blockedBy
     * @param list<string>|null $dependencies
     */
    public static function with(
        string $id,
        string $name,
        ?array $arguments = null,
        ?array $blockedBy = null,
        ?array $dependencies = null,
        ?string $venue = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['name'] = $name;

        null !== $arguments && $self['arguments'] = $arguments;
        null !== $blockedBy && $self['blockedBy'] = $blockedBy;
        null !== $dependencies && $self['dependencies'] = $dependencies;
        null !== $venue && $self['venue'] = $venue;

        return $self;
    }

    /**
     * Unique identifier for this deferred call.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Name of the tool.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

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
     * IDs of pending client calls blocking this call.
     *
     * @param list<string> $blockedBy
     */
    public function withBlockedBy(array $blockedBy): self
    {
        $self = clone $this;
        $self['blockedBy'] = $blockedBy;

        return $self;
    }

    /**
     * IDs of calls this depends on.
     *
     * @param list<string> $dependencies
     */
    public function withDependencies(array $dependencies): self
    {
        $self = clone $this;
        $self['dependencies'] = $dependencies;

        return $self;
    }

    /**
     * Execution venue (server or client).
     */
    public function withVenue(string $venue): self
    {
        $self = clone $this;
        $self['venue'] = $venue;

        return $self;
    }
}
