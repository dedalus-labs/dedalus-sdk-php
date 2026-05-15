<?php

declare(strict_types=1);

namespace DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseVerboseJSON;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Fields:  # noqa: D415.
 *
 * - word (required): str
 * - start (required): float
 * - end (required): float
 *
 * @phpstan-type WordShape = array{end: float, start: float, word: string}
 */
final class Word implements BaseModel
{
    /** @use SdkModel<WordShape> */
    use SdkModel;

    /**
     * End time of the word in seconds.
     */
    #[Required]
    public float $end;

    /**
     * Start time of the word in seconds.
     */
    #[Required]
    public float $start;

    /**
     * The text content of the word.
     */
    #[Required]
    public string $word;

    /**
     * `new Word()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Word::with(end: ..., start: ..., word: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Word)->withEnd(...)->withStart(...)->withWord(...)
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
    public static function with(float $end, float $start, string $word): self
    {
        $self = new self;

        $self['end'] = $end;
        $self['start'] = $start;
        $self['word'] = $word;

        return $self;
    }

    /**
     * End time of the word in seconds.
     */
    public function withEnd(float $end): self
    {
        $self = clone $this;
        $self['end'] = $end;

        return $self;
    }

    /**
     * Start time of the word in seconds.
     */
    public function withStart(float $start): self
    {
        $self = clone $this;
        $self['start'] = $start;

        return $self;
    }

    /**
     * The text content of the word.
     */
    public function withWord(string $word): self
    {
        $self = clone $this;
        $self['word'] = $word;

        return $self;
    }
}
