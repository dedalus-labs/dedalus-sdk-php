<?php

declare(strict_types=1);

namespace DedalusSDK\Audio\Speech;

use DedalusSDK\Audio\Speech\SpeechCreateParams\Model;
use DedalusSDK\Audio\Speech\SpeechCreateParams\ResponseFormat;
use DedalusSDK\Audio\Speech\SpeechCreateParams\StreamFormat;
use DedalusSDK\Audio\Speech\SpeechCreateParams\Voice;
use DedalusSDK\Audio\Speech\SpeechCreateParams\Voice\UnionMember1;
use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Concerns\SdkParams;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\VoiceIDsOrCustomVoice;

/**
 * Generate speech audio from text.
 *
 * Generates audio from the input text using text-to-speech models. Supports multiple
 * voices and output formats including mp3, opus, aac, flac, wav, and pcm.
 *
 * Returns streaming audio data that can be saved to a file or streamed directly to users.
 *
 * @see DedalusSDK\Services\Audio\SpeechService::create()
 *
 * @phpstan-import-type VoiceVariants from \DedalusSDK\Audio\Speech\SpeechCreateParams\Voice
 * @phpstan-import-type VoiceShape from \DedalusSDK\Audio\Speech\SpeechCreateParams\Voice
 *
 * @phpstan-type SpeechCreateParamsShape = array{
 *   input: string,
 *   model: string|Model|value-of<Model>,
 *   voice: VoiceShape,
 *   instructions?: string|null,
 *   responseFormat?: null|ResponseFormat|value-of<ResponseFormat>,
 *   speed?: float|null,
 *   streamFormat?: null|StreamFormat|value-of<StreamFormat>,
 * }
 */
final class SpeechCreateParams implements BaseModel
{
    /** @use SdkModel<SpeechCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The text to generate audio for. The maximum length is 4096 characters.
     */
    #[Required]
    public string $input;

    /**
     * One of the available [TTS models](/docs/models#tts): `tts-1`, `tts-1-hd`, `gpt-4o-mini-tts`, or `gpt-4o-mini-tts-2025-12-15`.
     *
     * @var string|value-of<Model> $model
     */
    #[Required(enum: Model::class)]
    public string $model;

    /**
     * The voice to use when generating the audio. Supported built-in voices are `alloy`, `ash`, `ballad`, `coral`, `echo`, `fable`, `onyx`, `nova`, `sage`, `shimmer`, `verse`, `marin`, and `cedar`. You may also provide a custom voice object with an `id`, for example `{ "id": "voice_1234" }`. Previews of the voices are available in the [Text to speech guide](/docs/guides/text-to-speech#voice-options).
     *
     * @var VoiceVariants $voice
     */
    #[Required(union: Voice::class)]
    public string|VoiceIDsOrCustomVoice $voice;

    /**
     * Control the voice of your generated audio with additional instructions. Does not work with `tts-1` or `tts-1-hd`.
     */
    #[Optional]
    public ?string $instructions;

    /**
     * The format to audio in. Supported formats are `mp3`, `opus`, `aac`, `flac`, `wav`, and `pcm`.
     *
     * @var value-of<ResponseFormat>|null $responseFormat
     */
    #[Optional('response_format', enum: ResponseFormat::class)]
    public ?string $responseFormat;

    /**
     * The speed of the generated audio. Select a value from `0.25` to `4.0`. `1.0` is the default.
     */
    #[Optional]
    public ?float $speed;

    /**
     * The format to stream the audio in. Supported formats are `sse` and `audio`. `sse` is not supported for `tts-1` or `tts-1-hd`.
     *
     * @var value-of<StreamFormat>|null $streamFormat
     */
    #[Optional('stream_format', enum: StreamFormat::class)]
    public ?string $streamFormat;

    /**
     * `new SpeechCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpeechCreateParams::with(input: ..., model: ..., voice: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpeechCreateParams)->withInput(...)->withModel(...)->withVoice(...)
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
     * @param string|Model|value-of<Model> $model
     * @param VoiceShape $voice
     * @param ResponseFormat|value-of<ResponseFormat>|null $responseFormat
     * @param StreamFormat|value-of<StreamFormat>|null $streamFormat
     */
    public static function with(
        string $input,
        Model|string $model,
        string|UnionMember1|VoiceIDsOrCustomVoice|array $voice,
        ?string $instructions = null,
        ResponseFormat|string|null $responseFormat = null,
        ?float $speed = null,
        StreamFormat|string|null $streamFormat = null,
    ): self {
        $self = new self;

        $self['input'] = $input;
        $self['model'] = $model;
        $self['voice'] = $voice;

        null !== $instructions && $self['instructions'] = $instructions;
        null !== $responseFormat && $self['responseFormat'] = $responseFormat;
        null !== $speed && $self['speed'] = $speed;
        null !== $streamFormat && $self['streamFormat'] = $streamFormat;

        return $self;
    }

    /**
     * The text to generate audio for. The maximum length is 4096 characters.
     */
    public function withInput(string $input): self
    {
        $self = clone $this;
        $self['input'] = $input;

        return $self;
    }

    /**
     * One of the available [TTS models](/docs/models#tts): `tts-1`, `tts-1-hd`, `gpt-4o-mini-tts`, or `gpt-4o-mini-tts-2025-12-15`.
     *
     * @param string|Model|value-of<Model> $model
     */
    public function withModel(Model|string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * The voice to use when generating the audio. Supported built-in voices are `alloy`, `ash`, `ballad`, `coral`, `echo`, `fable`, `onyx`, `nova`, `sage`, `shimmer`, `verse`, `marin`, and `cedar`. You may also provide a custom voice object with an `id`, for example `{ "id": "voice_1234" }`. Previews of the voices are available in the [Text to speech guide](/docs/guides/text-to-speech#voice-options).
     *
     * @param VoiceShape $voice
     */
    public function withVoice(
        string|UnionMember1|VoiceIDsOrCustomVoice|array $voice
    ): self {
        $self = clone $this;
        $self['voice'] = $voice;

        return $self;
    }

    /**
     * Control the voice of your generated audio with additional instructions. Does not work with `tts-1` or `tts-1-hd`.
     */
    public function withInstructions(string $instructions): self
    {
        $self = clone $this;
        $self['instructions'] = $instructions;

        return $self;
    }

    /**
     * The format to audio in. Supported formats are `mp3`, `opus`, `aac`, `flac`, `wav`, and `pcm`.
     *
     * @param ResponseFormat|value-of<ResponseFormat> $responseFormat
     */
    public function withResponseFormat(
        ResponseFormat|string $responseFormat
    ): self {
        $self = clone $this;
        $self['responseFormat'] = $responseFormat;

        return $self;
    }

    /**
     * The speed of the generated audio. Select a value from `0.25` to `4.0`. `1.0` is the default.
     */
    public function withSpeed(float $speed): self
    {
        $self = clone $this;
        $self['speed'] = $speed;

        return $self;
    }

    /**
     * The format to stream the audio in. Supported formats are `sse` and `audio`. `sse` is not supported for `tts-1` or `tts-1-hd`.
     *
     * @param StreamFormat|value-of<StreamFormat> $streamFormat
     */
    public function withStreamFormat(StreamFormat|string $streamFormat): self
    {
        $self = clone $this;
        $self['streamFormat'] = $streamFormat;

        return $self;
    }
}
