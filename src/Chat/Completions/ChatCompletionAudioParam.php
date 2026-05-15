<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Chat\Completions\ChatCompletionAudioParam\Format;
use DedalusSDK\Chat\Completions\ChatCompletionAudioParam\Voice;
use DedalusSDK\Chat\Completions\ChatCompletionAudioParam\Voice\UnionMember1;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\VoiceIDsOrCustomVoice;

/**
 * Parameters for audio output. Required when audio output is requested with
 * `modalities: ["audio"]`. [Learn more](/docs/guides/audio).
 *
 * Fields:
 * - voice (required): VoiceIdsOrCustomVoice
 * - format (required): Literal["wav", "aac", "mp3", "flac", "opus", "pcm16"]
 *
 * @phpstan-import-type VoiceVariants from \DedalusSDK\Chat\Completions\ChatCompletionAudioParam\Voice
 * @phpstan-import-type VoiceShape from \DedalusSDK\Chat\Completions\ChatCompletionAudioParam\Voice
 *
 * @phpstan-type ChatCompletionAudioParamShape = array{
 *   format: Format|value-of<Format>, voice: VoiceShape
 * }
 */
final class ChatCompletionAudioParam implements BaseModel
{
    /** @use SdkModel<ChatCompletionAudioParamShape> */
    use SdkModel;

    /**
     * Specifies the output audio format. Must be one of `wav`, `mp3`, `flac`,
     * `opus`, or `pcm16`.
     *
     * @var value-of<Format> $format
     */
    #[Required(enum: Format::class)]
    public string $format;

    /**
     * The voice the model uses to respond. Supported built-in voices are
     * `alloy`, `ash`, `ballad`, `coral`, `echo`, `fable`, `nova`, `onyx`,
     * `sage`, `shimmer`, `marin`, and `cedar`. You may also provide a
     * custom voice object with an `id`, for example `{ "id": "voice_1234" }`.
     *
     * @var VoiceVariants $voice
     */
    #[Required(union: Voice::class)]
    public string|VoiceIDsOrCustomVoice $voice;

    /**
     * `new ChatCompletionAudioParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChatCompletionAudioParam::with(format: ..., voice: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChatCompletionAudioParam)->withFormat(...)->withVoice(...)
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
     * @param VoiceShape $voice
     */
    public static function with(
        Format|string $format,
        string|UnionMember1|VoiceIDsOrCustomVoice|array $voice,
    ): self {
        $self = new self;

        $self['format'] = $format;
        $self['voice'] = $voice;

        return $self;
    }

    /**
     * Specifies the output audio format. Must be one of `wav`, `mp3`, `flac`,
     * `opus`, or `pcm16`.
     *
     * @param Format|value-of<Format> $format
     */
    public function withFormat(Format|string $format): self
    {
        $self = clone $this;
        $self['format'] = $format;

        return $self;
    }

    /**
     * The voice the model uses to respond. Supported built-in voices are
     * `alloy`, `ash`, `ballad`, `coral`, `echo`, `fable`, `nova`, `onyx`,
     * `sage`, `shimmer`, `marin`, and `cedar`. You may also provide a
     * custom voice object with an `id`, for example `{ "id": "voice_1234" }`.
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
}
