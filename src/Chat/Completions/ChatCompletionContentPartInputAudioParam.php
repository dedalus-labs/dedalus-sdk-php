<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Chat\Completions\ChatCompletionContentPartInputAudioParam\InputAudio;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Learn about [audio inputs](/docs/guides/audio).
 *
 * Fields:
 * - type (required): Literal["input_audio"]
 * - input_audio (required): InputAudio
 *
 * @phpstan-import-type InputAudioShape from \DedalusSDK\Chat\Completions\ChatCompletionContentPartInputAudioParam\InputAudio
 *
 * @phpstan-type ChatCompletionContentPartInputAudioParamShape = array{
 *   inputAudio: InputAudio|InputAudioShape, type: 'input_audio'
 * }
 */
final class ChatCompletionContentPartInputAudioParam implements BaseModel
{
    /** @use SdkModel<ChatCompletionContentPartInputAudioParamShape> */
    use SdkModel;

    /**
     * The type of the content part. Always `input_audio`.
     *
     * @var 'input_audio' $type
     */
    #[Required]
    public string $type = 'input_audio';

    /**
     * Schema for InputAudio.
     *
     * Fields:
     * - data (required): str
     * - format (required): Literal["wav", "mp3"]
     */
    #[Required('input_audio')]
    public InputAudio $inputAudio;

    /**
     * `new ChatCompletionContentPartInputAudioParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChatCompletionContentPartInputAudioParam::with(inputAudio: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChatCompletionContentPartInputAudioParam)->withInputAudio(...)
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
     * @param InputAudio|InputAudioShape $inputAudio
     */
    public static function with(InputAudio|array $inputAudio): self
    {
        $self = new self;

        $self['inputAudio'] = $inputAudio;

        return $self;
    }

    /**
     * Schema for InputAudio.
     *
     * Fields:
     * - data (required): str
     * - format (required): Literal["wav", "mp3"]
     *
     * @param InputAudio|InputAudioShape $inputAudio
     */
    public function withInputAudio(InputAudio|array $inputAudio): self
    {
        $self = clone $this;
        $self['inputAudio'] = $inputAudio;

        return $self;
    }

    /**
     * The type of the content part. Always `input_audio`.
     *
     * @param 'input_audio' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
