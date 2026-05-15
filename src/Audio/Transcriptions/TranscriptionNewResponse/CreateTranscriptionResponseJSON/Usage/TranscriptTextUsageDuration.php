<?php

declare(strict_types=1);

namespace DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON\Usage;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Usage statistics for models billed by audio input duration.
 *
 * Fields:
 *   - type (required): Literal['duration']
 *   - seconds (required): float
 *
 * @phpstan-type TranscriptTextUsageDurationShape = array{
 *   seconds: float, type: 'duration'
 * }
 */
final class TranscriptTextUsageDuration implements BaseModel
{
    /** @use SdkModel<TranscriptTextUsageDurationShape> */
    use SdkModel;

    /**
     * The type of the usage object. Always `duration` for this variant.
     *
     * @var 'duration' $type
     */
    #[Required]
    public string $type = 'duration';

    /**
     * Duration of the input audio in seconds.
     */
    #[Required]
    public float $seconds;

    /**
     * `new TranscriptTextUsageDuration()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TranscriptTextUsageDuration::with(seconds: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TranscriptTextUsageDuration)->withSeconds(...)
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
    public static function with(float $seconds): self
    {
        $self = new self;

        $self['seconds'] = $seconds;

        return $self;
    }

    /**
     * Duration of the input audio in seconds.
     */
    public function withSeconds(float $seconds): self
    {
        $self = clone $this;
        $self['seconds'] = $seconds;

        return $self;
    }

    /**
     * The type of the usage object. Always `duration` for this variant.
     *
     * @param 'duration' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
