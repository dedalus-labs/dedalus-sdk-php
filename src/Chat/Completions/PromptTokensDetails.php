<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Breakdown of tokens used in the prompt.
 *
 * Fields:
 * - audio_tokens (optional): int
 * - cached_tokens (optional): int
 *
 * @phpstan-type PromptTokensDetailsShape = array{
 *   audioTokens?: int|null, cachedTokens?: int|null
 * }
 */
final class PromptTokensDetails implements BaseModel
{
    /** @use SdkModel<PromptTokensDetailsShape> */
    use SdkModel;

    /**
     * Audio input tokens present in the prompt.
     */
    #[Optional('audio_tokens')]
    public ?int $audioTokens;

    /**
     * Cached tokens present in the prompt.
     */
    #[Optional('cached_tokens')]
    public ?int $cachedTokens;

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
        ?int $audioTokens = null,
        ?int $cachedTokens = null
    ): self {
        $self = new self;

        null !== $audioTokens && $self['audioTokens'] = $audioTokens;
        null !== $cachedTokens && $self['cachedTokens'] = $cachedTokens;

        return $self;
    }

    /**
     * Audio input tokens present in the prompt.
     */
    public function withAudioTokens(int $audioTokens): self
    {
        $self = clone $this;
        $self['audioTokens'] = $audioTokens;

        return $self;
    }

    /**
     * Cached tokens present in the prompt.
     */
    public function withCachedTokens(int $cachedTokens): self
    {
        $self = clone $this;
        $self['cachedTokens'] = $cachedTokens;

        return $self;
    }
}
