<?php

declare(strict_types=1);

namespace DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse;

use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseVerboseJSON\Segment;
use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseVerboseJSON\Usage;
use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseVerboseJSON\Word;
use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Represents a verbose json transcription response returned by model, based on the provided input.
 *
 * Fields:
 *   - language (required): str
 *   - duration (required): float
 *   - text (required): str
 *   - words (optional): list[TranscriptionWord]
 *   - segments (optional): list[TranscriptionSegment]
 *   - usage (optional): TranscriptTextUsageDuration
 *
 * @phpstan-import-type SegmentShape from \DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseVerboseJSON\Segment
 * @phpstan-import-type UsageShape from \DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseVerboseJSON\Usage
 * @phpstan-import-type WordShape from \DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseVerboseJSON\Word
 *
 * @phpstan-type CreateTranscriptionResponseVerboseJSONShape = array{
 *   duration: float,
 *   language: string,
 *   text: string,
 *   segments?: list<Segment|SegmentShape>|null,
 *   usage?: null|Usage|UsageShape,
 *   words?: list<Word|WordShape>|null,
 * }
 */
final class CreateTranscriptionResponseVerboseJSON implements BaseModel
{
    /** @use SdkModel<CreateTranscriptionResponseVerboseJSONShape> */
    use SdkModel;

    /**
     * The duration of the input audio.
     */
    #[Required]
    public float $duration;

    /**
     * The language of the input audio.
     */
    #[Required]
    public string $language;

    /**
     * The transcribed text.
     */
    #[Required]
    public string $text;

    /**
     * Segments of the transcribed text and their corresponding details.
     *
     * @var list<Segment>|null $segments
     */
    #[Optional(list: Segment::class)]
    public ?array $segments;

    /**
     * Usage statistics for models billed by audio input duration.
     */
    #[Optional]
    public ?Usage $usage;

    /**
     * Extracted words and their corresponding timestamps.
     *
     * @var list<Word>|null $words
     */
    #[Optional(list: Word::class)]
    public ?array $words;

    /**
     * `new CreateTranscriptionResponseVerboseJSON()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CreateTranscriptionResponseVerboseJSON::with(
     *   duration: ..., language: ..., text: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CreateTranscriptionResponseVerboseJSON)
     *   ->withDuration(...)
     *   ->withLanguage(...)
     *   ->withText(...)
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
     * @param list<Segment|SegmentShape>|null $segments
     * @param Usage|UsageShape|null $usage
     * @param list<Word|WordShape>|null $words
     */
    public static function with(
        float $duration,
        string $language,
        string $text,
        ?array $segments = null,
        Usage|array|null $usage = null,
        ?array $words = null,
    ): self {
        $self = new self;

        $self['duration'] = $duration;
        $self['language'] = $language;
        $self['text'] = $text;

        null !== $segments && $self['segments'] = $segments;
        null !== $usage && $self['usage'] = $usage;
        null !== $words && $self['words'] = $words;

        return $self;
    }

    /**
     * The duration of the input audio.
     */
    public function withDuration(float $duration): self
    {
        $self = clone $this;
        $self['duration'] = $duration;

        return $self;
    }

    /**
     * The language of the input audio.
     */
    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * The transcribed text.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Segments of the transcribed text and their corresponding details.
     *
     * @param list<Segment|SegmentShape> $segments
     */
    public function withSegments(array $segments): self
    {
        $self = clone $this;
        $self['segments'] = $segments;

        return $self;
    }

    /**
     * Usage statistics for models billed by audio input duration.
     *
     * @param Usage|UsageShape $usage
     */
    public function withUsage(Usage|array $usage): self
    {
        $self = clone $this;
        $self['usage'] = $usage;

        return $self;
    }

    /**
     * Extracted words and their corresponding timestamps.
     *
     * @param list<Word|WordShape> $words
     */
    public function withWords(array $words): self
    {
        $self = clone $this;
        $self['words'] = $words;

        return $self;
    }
}
