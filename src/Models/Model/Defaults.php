<?php

declare(strict_types=1);

namespace DedalusSDK\Models\Model;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Provider-declared default parameters for model generation.
 *
 * @phpstan-type DefaultsShape = array{
 *   maxOutputTokens?: int|null,
 *   temperature?: float|null,
 *   topK?: int|null,
 *   topP?: float|null,
 * }
 */
final class Defaults implements BaseModel
{
    /** @use SdkModel<DefaultsShape> */
    use SdkModel;

    /**
     * Default maximum output tokens.
     */
    #[Optional('max_output_tokens', nullable: true)]
    public ?int $maxOutputTokens;

    /**
     * Default temperature setting.
     */
    #[Optional(nullable: true)]
    public ?float $temperature;

    /**
     * Default top_k setting.
     */
    #[Optional('top_k', nullable: true)]
    public ?int $topK;

    /**
     * Default top_p setting.
     */
    #[Optional('top_p', nullable: true)]
    public ?float $topP;

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
        ?int $maxOutputTokens = null,
        ?float $temperature = null,
        ?int $topK = null,
        ?float $topP = null,
    ): self {
        $self = new self;

        null !== $maxOutputTokens && $self['maxOutputTokens'] = $maxOutputTokens;
        null !== $temperature && $self['temperature'] = $temperature;
        null !== $topK && $self['topK'] = $topK;
        null !== $topP && $self['topP'] = $topP;

        return $self;
    }

    /**
     * Default maximum output tokens.
     */
    public function withMaxOutputTokens(?int $maxOutputTokens): self
    {
        $self = clone $this;
        $self['maxOutputTokens'] = $maxOutputTokens;

        return $self;
    }

    /**
     * Default temperature setting.
     */
    public function withTemperature(?float $temperature): self
    {
        $self = clone $this;
        $self['temperature'] = $temperature;

        return $self;
    }

    /**
     * Default top_k setting.
     */
    public function withTopK(?int $topK): self
    {
        $self = clone $this;
        $self['topK'] = $topK;

        return $self;
    }

    /**
     * Default top_p setting.
     */
    public function withTopP(?float $topP): self
    {
        $self = clone $this;
        $self['topP'] = $topP;

        return $self;
    }
}
