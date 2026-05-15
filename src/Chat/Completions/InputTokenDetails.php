<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Details about the input tokens billed for this request.
 *
 * Fields:
 *   - text_tokens (optional): int
 *   - audio_tokens (optional): int
 *
 * @phpstan-type InputTokenDetailsShape = array{
 *   audioTokens?: int|null, textTokens?: int|null
 * }
 */
final class InputTokenDetails implements BaseModel
{
    /** @use SdkModel<InputTokenDetailsShape> */
    use SdkModel;

    /**
     * Number of audio tokens billed for this request.
     */
    #[Optional('audio_tokens')]
    public ?int $audioTokens;

    /**
     * Number of text tokens billed for this request.
     */
    #[Optional('text_tokens')]
    public ?int $textTokens;

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
        ?int $textTokens = null
    ): self {
        $self = new self;

        null !== $audioTokens && $self['audioTokens'] = $audioTokens;
        null !== $textTokens && $self['textTokens'] = $textTokens;

        return $self;
    }

    /**
     * Number of audio tokens billed for this request.
     */
    public function withAudioTokens(int $audioTokens): self
    {
        $self = clone $this;
        $self['audioTokens'] = $audioTokens;

        return $self;
    }

    /**
     * Number of text tokens billed for this request.
     */
    public function withTextTokens(int $textTokens): self
    {
        $self = clone $this;
        $self['textTokens'] = $textTokens;

        return $self;
    }
}
