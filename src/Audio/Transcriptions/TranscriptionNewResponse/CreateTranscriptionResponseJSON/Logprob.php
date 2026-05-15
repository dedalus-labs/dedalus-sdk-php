<?php

declare(strict_types=1);

namespace DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Fields:  # noqa: D415.
 *
 * - token (optional): str
 * - logprob (optional): float
 * - bytes (optional): list[float]
 *
 * @phpstan-type LogprobShape = array{
 *   token?: string|null, bytes?: list<float>|null, logprob?: float|null
 * }
 */
final class Logprob implements BaseModel
{
    /** @use SdkModel<LogprobShape> */
    use SdkModel;

    /**
     * The token in the transcription.
     */
    #[Optional]
    public ?string $token;

    /**
     * The bytes of the token.
     *
     * @var list<float>|null $bytes
     */
    #[Optional(list: 'float')]
    public ?array $bytes;

    /**
     * The log probability of the token.
     */
    #[Optional]
    public ?float $logprob;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<float>|null $bytes
     */
    public static function with(
        ?string $token = null,
        ?array $bytes = null,
        ?float $logprob = null
    ): self {
        $self = new self;

        null !== $token && $self['token'] = $token;
        null !== $bytes && $self['bytes'] = $bytes;
        null !== $logprob && $self['logprob'] = $logprob;

        return $self;
    }

    /**
     * The token in the transcription.
     */
    public function withToken(string $token): self
    {
        $self = clone $this;
        $self['token'] = $token;

        return $self;
    }

    /**
     * The bytes of the token.
     *
     * @param list<float> $bytes
     */
    public function withBytes(array $bytes): self
    {
        $self = clone $this;
        $self['bytes'] = $bytes;

        return $self;
    }

    /**
     * The log probability of the token.
     */
    public function withLogprob(float $logprob): self
    {
        $self = clone $this;
        $self['logprob'] = $logprob;

        return $self;
    }
}
