<?php

declare(strict_types=1);

namespace DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseVerboseJSON;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Fields:  # noqa: D415.
 *
 * - id (required): int
 * - seek (required): int
 * - start (required): float
 * - end (required): float
 * - text (required): str
 * - tokens (required): list[int]
 * - temperature (required): float
 * - avg_logprob (required): float
 * - compression_ratio (required): float
 * - no_speech_prob (required): float
 *
 * @phpstan-type SegmentShape = array{
 *   id: int,
 *   avgLogprob: float,
 *   compressionRatio: float,
 *   end: float,
 *   noSpeechProb: float,
 *   seek: int,
 *   start: float,
 *   temperature: float,
 *   text: string,
 *   tokens: list<int>,
 * }
 */
final class Segment implements BaseModel
{
    /** @use SdkModel<SegmentShape> */
    use SdkModel;

    /**
     * Unique identifier of the segment.
     */
    #[Required]
    public int $id;

    /**
     * Average logprob of the segment. If the value is lower than -1, consider the logprobs failed.
     */
    #[Required('avg_logprob')]
    public float $avgLogprob;

    /**
     * Compression ratio of the segment. If the value is greater than 2.4, consider the compression failed.
     */
    #[Required('compression_ratio')]
    public float $compressionRatio;

    /**
     * End time of the segment in seconds.
     */
    #[Required]
    public float $end;

    /**
     * Probability of no speech in the segment. If the value is higher than 1.0 and the `avg_logprob` is below -1, consider this segment silent.
     */
    #[Required('no_speech_prob')]
    public float $noSpeechProb;

    /**
     * Seek offset of the segment.
     */
    #[Required]
    public int $seek;

    /**
     * Start time of the segment in seconds.
     */
    #[Required]
    public float $start;

    /**
     * Temperature parameter used for generating the segment.
     */
    #[Required]
    public float $temperature;

    /**
     * Text content of the segment.
     */
    #[Required]
    public string $text;

    /**
     * Array of token IDs for the text content.
     *
     * @var list<int> $tokens
     */
    #[Required(list: 'int')]
    public array $tokens;

    /**
     * `new Segment()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Segment::with(
     *   id: ...,
     *   avgLogprob: ...,
     *   compressionRatio: ...,
     *   end: ...,
     *   noSpeechProb: ...,
     *   seek: ...,
     *   start: ...,
     *   temperature: ...,
     *   text: ...,
     *   tokens: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Segment)
     *   ->withID(...)
     *   ->withAvgLogprob(...)
     *   ->withCompressionRatio(...)
     *   ->withEnd(...)
     *   ->withNoSpeechProb(...)
     *   ->withSeek(...)
     *   ->withStart(...)
     *   ->withTemperature(...)
     *   ->withText(...)
     *   ->withTokens(...)
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
     * @param list<int> $tokens
     */
    public static function with(
        int $id,
        float $avgLogprob,
        float $compressionRatio,
        float $end,
        float $noSpeechProb,
        int $seek,
        float $start,
        float $temperature,
        string $text,
        array $tokens,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['avgLogprob'] = $avgLogprob;
        $self['compressionRatio'] = $compressionRatio;
        $self['end'] = $end;
        $self['noSpeechProb'] = $noSpeechProb;
        $self['seek'] = $seek;
        $self['start'] = $start;
        $self['temperature'] = $temperature;
        $self['text'] = $text;
        $self['tokens'] = $tokens;

        return $self;
    }

    /**
     * Unique identifier of the segment.
     */
    public function withID(int $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Average logprob of the segment. If the value is lower than -1, consider the logprobs failed.
     */
    public function withAvgLogprob(float $avgLogprob): self
    {
        $self = clone $this;
        $self['avgLogprob'] = $avgLogprob;

        return $self;
    }

    /**
     * Compression ratio of the segment. If the value is greater than 2.4, consider the compression failed.
     */
    public function withCompressionRatio(float $compressionRatio): self
    {
        $self = clone $this;
        $self['compressionRatio'] = $compressionRatio;

        return $self;
    }

    /**
     * End time of the segment in seconds.
     */
    public function withEnd(float $end): self
    {
        $self = clone $this;
        $self['end'] = $end;

        return $self;
    }

    /**
     * Probability of no speech in the segment. If the value is higher than 1.0 and the `avg_logprob` is below -1, consider this segment silent.
     */
    public function withNoSpeechProb(float $noSpeechProb): self
    {
        $self = clone $this;
        $self['noSpeechProb'] = $noSpeechProb;

        return $self;
    }

    /**
     * Seek offset of the segment.
     */
    public function withSeek(int $seek): self
    {
        $self = clone $this;
        $self['seek'] = $seek;

        return $self;
    }

    /**
     * Start time of the segment in seconds.
     */
    public function withStart(float $start): self
    {
        $self = clone $this;
        $self['start'] = $start;

        return $self;
    }

    /**
     * Temperature parameter used for generating the segment.
     */
    public function withTemperature(float $temperature): self
    {
        $self = clone $this;
        $self['temperature'] = $temperature;

        return $self;
    }

    /**
     * Text content of the segment.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Array of token IDs for the text content.
     *
     * @param list<int> $tokens
     */
    public function withTokens(array $tokens): self
    {
        $self = clone $this;
        $self['tokens'] = $tokens;

        return $self;
    }
}
