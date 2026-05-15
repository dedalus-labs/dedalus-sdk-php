<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionContentPartInputAudioParam;

use DedalusSDK\Chat\Completions\ChatCompletionContentPartInputAudioParam\InputAudio\Format;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Schema for InputAudio.
 *
 * Fields:
 * - data (required): str
 * - format (required): Literal["wav", "mp3"]
 *
 * @phpstan-type InputAudioShape = array{
 *   data: string, format: Format|value-of<Format>
 * }
 */
final class InputAudio implements BaseModel
{
    /** @use SdkModel<InputAudioShape> */
    use SdkModel;

    /**
     * Base64 encoded audio data.
     */
    #[Required]
    public string $data;

    /**
     * The format of the encoded audio data. Currently supports "wav" and "mp3".
     *
     * @var value-of<Format> $format
     */
    #[Required(enum: Format::class)]
    public string $format;

    /**
     * `new InputAudio()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * InputAudio::with(data: ..., format: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new InputAudio)->withData(...)->withFormat(...)
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
     * @param Format|value-of<Format> $format
     */
    public static function with(string $data, Format|string $format): self
    {
        $self = new self;

        $self['data'] = $data;
        $self['format'] = $format;

        return $self;
    }

    /**
     * Base64 encoded audio data.
     */
    public function withData(string $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }

    /**
     * The format of the encoded audio data. Currently supports "wav" and "mp3".
     *
     * @param Format|value-of<Format> $format
     */
    public function withFormat(Format|string $format): self
    {
        $self = clone $this;
        $self['format'] = $format;

        return $self;
    }
}
