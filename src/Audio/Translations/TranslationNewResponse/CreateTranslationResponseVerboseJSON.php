<?php

declare(strict_types=1);

namespace DedalusSDK\Audio\Translations\TranslationNewResponse;

use DedalusSDK\Audio\Translations\TranslationNewResponse\CreateTranslationResponseVerboseJSON\Segment;
use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Fields:  # noqa: D415.
 *
 * - language (required): str
 * - duration (required): float
 * - text (required): str
 * - segments (optional): list[TranscriptionSegment]
 *
 * @phpstan-import-type SegmentShape from \DedalusSDK\Audio\Translations\TranslationNewResponse\CreateTranslationResponseVerboseJSON\Segment
 *
 * @phpstan-type CreateTranslationResponseVerboseJSONShape = array{
 *   duration: float,
 *   language: string,
 *   text: string,
 *   segments?: list<Segment|SegmentShape>|null,
 * }
 */
final class CreateTranslationResponseVerboseJSON implements BaseModel
{
    /** @use SdkModel<CreateTranslationResponseVerboseJSONShape> */
    use SdkModel;

    /**
     * The duration of the input audio.
     */
    #[Required]
    public float $duration;

    /**
     * The language of the output translation (always `english`).
     */
    #[Required]
    public string $language;

    /**
     * The translated text.
     */
    #[Required]
    public string $text;

    /**
     * Segments of the translated text and their corresponding details.
     *
     * @var list<Segment>|null $segments
     */
    #[Optional(list: Segment::class)]
    public ?array $segments;

    /**
     * `new CreateTranslationResponseVerboseJSON()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CreateTranslationResponseVerboseJSON::with(
     *   duration: ..., language: ..., text: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CreateTranslationResponseVerboseJSON)
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
     */
    public static function with(
        float $duration,
        string $language,
        string $text,
        ?array $segments = null
    ): self {
        $self = new self;

        $self['duration'] = $duration;
        $self['language'] = $language;
        $self['text'] = $text;

        null !== $segments && $self['segments'] = $segments;

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
     * The language of the output translation (always `english`).
     */
    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * The translated text.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Segments of the translated text and their corresponding details.
     *
     * @param list<Segment|SegmentShape> $segments
     */
    public function withSegments(array $segments): self
    {
        $self = clone $this;
        $self['segments'] = $segments;

        return $self;
    }
}
