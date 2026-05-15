<?php

declare(strict_types=1);

namespace DedalusSDK\Models\Model;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Normalized model capabilities across all providers.
 *
 * @phpstan-type CapabilitiesShape = array{
 *   audio?: bool|null,
 *   imageGeneration?: bool|null,
 *   inputTokenLimit?: int|null,
 *   outputTokenLimit?: int|null,
 *   streaming?: bool|null,
 *   structuredOutput?: bool|null,
 *   text?: bool|null,
 *   thinking?: bool|null,
 *   tools?: bool|null,
 *   vision?: bool|null,
 * }
 */
final class Capabilities implements BaseModel
{
    /** @use SdkModel<CapabilitiesShape> */
    use SdkModel;

    /**
     * Supports audio processing.
     */
    #[Optional(nullable: true)]
    public ?bool $audio;

    /**
     * Supports image generation.
     */
    #[Optional('image_generation', nullable: true)]
    public ?bool $imageGeneration;

    /**
     * Maximum input tokens.
     */
    #[Optional('input_token_limit', nullable: true)]
    public ?int $inputTokenLimit;

    /**
     * Maximum output tokens.
     */
    #[Optional('output_token_limit', nullable: true)]
    public ?int $outputTokenLimit;

    /**
     * Supports streaming responses.
     */
    #[Optional(nullable: true)]
    public ?bool $streaming;

    /**
     * Supports structured JSON output.
     */
    #[Optional('structured_output', nullable: true)]
    public ?bool $structuredOutput;

    /**
     * Supports text generation.
     */
    #[Optional(nullable: true)]
    public ?bool $text;

    /**
     * Supports extended thinking/reasoning.
     */
    #[Optional(nullable: true)]
    public ?bool $thinking;

    /**
     * Supports function/tool calling.
     */
    #[Optional(nullable: true)]
    public ?bool $tools;

    /**
     * Supports image understanding.
     */
    #[Optional(nullable: true)]
    public ?bool $vision;

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
        ?bool $audio = null,
        ?bool $imageGeneration = null,
        ?int $inputTokenLimit = null,
        ?int $outputTokenLimit = null,
        ?bool $streaming = null,
        ?bool $structuredOutput = null,
        ?bool $text = null,
        ?bool $thinking = null,
        ?bool $tools = null,
        ?bool $vision = null,
    ): self {
        $self = new self;

        null !== $audio && $self['audio'] = $audio;
        null !== $imageGeneration && $self['imageGeneration'] = $imageGeneration;
        null !== $inputTokenLimit && $self['inputTokenLimit'] = $inputTokenLimit;
        null !== $outputTokenLimit && $self['outputTokenLimit'] = $outputTokenLimit;
        null !== $streaming && $self['streaming'] = $streaming;
        null !== $structuredOutput && $self['structuredOutput'] = $structuredOutput;
        null !== $text && $self['text'] = $text;
        null !== $thinking && $self['thinking'] = $thinking;
        null !== $tools && $self['tools'] = $tools;
        null !== $vision && $self['vision'] = $vision;

        return $self;
    }

    /**
     * Supports audio processing.
     */
    public function withAudio(?bool $audio): self
    {
        $self = clone $this;
        $self['audio'] = $audio;

        return $self;
    }

    /**
     * Supports image generation.
     */
    public function withImageGeneration(?bool $imageGeneration): self
    {
        $self = clone $this;
        $self['imageGeneration'] = $imageGeneration;

        return $self;
    }

    /**
     * Maximum input tokens.
     */
    public function withInputTokenLimit(?int $inputTokenLimit): self
    {
        $self = clone $this;
        $self['inputTokenLimit'] = $inputTokenLimit;

        return $self;
    }

    /**
     * Maximum output tokens.
     */
    public function withOutputTokenLimit(?int $outputTokenLimit): self
    {
        $self = clone $this;
        $self['outputTokenLimit'] = $outputTokenLimit;

        return $self;
    }

    /**
     * Supports streaming responses.
     */
    public function withStreaming(?bool $streaming): self
    {
        $self = clone $this;
        $self['streaming'] = $streaming;

        return $self;
    }

    /**
     * Supports structured JSON output.
     */
    public function withStructuredOutput(?bool $structuredOutput): self
    {
        $self = clone $this;
        $self['structuredOutput'] = $structuredOutput;

        return $self;
    }

    /**
     * Supports text generation.
     */
    public function withText(?bool $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Supports extended thinking/reasoning.
     */
    public function withThinking(?bool $thinking): self
    {
        $self = clone $this;
        $self['thinking'] = $thinking;

        return $self;
    }

    /**
     * Supports function/tool calling.
     */
    public function withTools(?bool $tools): self
    {
        $self = clone $this;
        $self['tools'] = $tools;

        return $self;
    }

    /**
     * Supports image understanding.
     */
    public function withVision(?bool $vision): self
    {
        $self = clone $this;
        $self['vision'] = $vision;

        return $self;
    }
}
