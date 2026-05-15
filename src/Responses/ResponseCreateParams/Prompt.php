<?php

declare(strict_types=1);

namespace DedalusSDK\Responses\ResponseCreateParams;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\Core\Conversion\MapOf;
use DedalusSDK\JSONValueInput;

/**
 * Stored prompt template reference (BYOK).
 *
 * @phpstan-type PromptShape = array{
 *   id: string, variables?: array<string,mixed>|null, version?: string|null
 * }
 */
final class Prompt implements BaseModel
{
    /** @use SdkModel<PromptShape> */
    use SdkModel;

    /**
     * Identifier of the stored prompt.
     */
    #[Required]
    public string $id;

    /**
     * Variables to substitute into the stored prompt template.
     *
     * @var array<string,mixed>|null $variables
     */
    #[Optional(
        type: new MapOf(JSONValueInput::class, nullable: true),
        nullable: true
    )]
    public ?array $variables;

    /**
     * Optional version identifier of the stored prompt.
     */
    #[Optional(nullable: true)]
    public ?string $version;

    /**
     * `new Prompt()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Prompt::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Prompt)->withID(...)
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
     * @param array<string,mixed>|null $variables
     */
    public static function with(
        string $id,
        ?array $variables = null,
        ?string $version = null
    ): self {
        $self = new self;

        $self['id'] = $id;

        null !== $variables && $self['variables'] = $variables;
        null !== $version && $self['version'] = $version;

        return $self;
    }

    /**
     * Identifier of the stored prompt.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Variables to substitute into the stored prompt template.
     *
     * @param array<string,mixed>|null $variables
     */
    public function withVariables(?array $variables): self
    {
        $self = clone $this;
        $self['variables'] = $variables;

        return $self;
    }

    /**
     * Optional version identifier of the stored prompt.
     */
    public function withVersion(?string $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }
}
