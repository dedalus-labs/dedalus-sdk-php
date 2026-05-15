<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletion;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Error details for a single MCP server failure.
 *
 * @phpstan-type MCPServerErrorShape = array{
 *   message: string, code?: string|null, recommendation?: string|null
 * }
 */
final class MCPServerError implements BaseModel
{
    /** @use SdkModel<MCPServerErrorShape> */
    use SdkModel;

    /**
     * Human-readable error message.
     */
    #[Required]
    public string $message;

    /**
     * Machine-readable error code.
     */
    #[Optional(nullable: true)]
    public ?string $code;

    /**
     * Suggested action for the user.
     */
    #[Optional(nullable: true)]
    public ?string $recommendation;

    /**
     * `new MCPServerError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MCPServerError::with(message: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MCPServerError)->withMessage(...)
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
     */
    public static function with(
        string $message,
        ?string $code = null,
        ?string $recommendation = null
    ): self {
        $self = new self;

        $self['message'] = $message;

        null !== $code && $self['code'] = $code;
        null !== $recommendation && $self['recommendation'] = $recommendation;

        return $self;
    }

    /**
     * Human-readable error message.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * Machine-readable error code.
     */
    public function withCode(?string $code): self
    {
        $self = clone $this;
        $self['code'] = $code;

        return $self;
    }

    /**
     * Suggested action for the user.
     */
    public function withRecommendation(?string $recommendation): self
    {
        $self = clone $this;
        $self['recommendation'] = $recommendation;

        return $self;
    }
}
