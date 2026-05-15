<?php

declare(strict_types=1);

namespace DedalusSDK\Audio\Translations;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Concerns\SdkParams;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\Core\FileParam;

/**
 * Translate audio into English.
 *
 * Translates audio files in any supported language to English text using OpenAI's
 * Whisper model. Supports the same audio formats as transcription. Maximum file size
 * is 25 MB.
 *
 * Args:
 *     file: Audio file to translate (required)
 *     model: Model ID to use (e.g., "openai/whisper-1")
 *     prompt: Optional text to guide the model's style
 *     response_format: Format of the output (json, text, srt, verbose_json, vtt)
 *     temperature: Sampling temperature between 0 and 1
 *
 * Returns:
 *     Translation object with the English translation
 *
 * @see DedalusSDK\Services\Audio\TranslationsService::create()
 *
 * @phpstan-type TranslationCreateParamsShape = array{
 *   file: string|FileParam,
 *   model: string,
 *   prompt?: string|null,
 *   responseFormat?: string|null,
 *   temperature?: float|null,
 * }
 */
final class TranslationCreateParams implements BaseModel
{
    /** @use SdkModel<TranslationCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $file;

    #[Required]
    public string $model;

    #[Optional(nullable: true)]
    public ?string $prompt;

    #[Optional('response_format', nullable: true)]
    public ?string $responseFormat;

    #[Optional(nullable: true)]
    public ?float $temperature;

    /**
     * `new TranslationCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TranslationCreateParams::with(file: ..., model: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TranslationCreateParams)->withFile(...)->withModel(...)
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
    public static function with(
        string|FileParam $file,
        string $model,
        ?string $prompt = null,
        ?string $responseFormat = null,
        ?float $temperature = null,
    ): self {
        $self = new self;

        $self['file'] = $file;
        $self['model'] = $model;

        null !== $prompt && $self['prompt'] = $prompt;
        null !== $responseFormat && $self['responseFormat'] = $responseFormat;
        null !== $temperature && $self['temperature'] = $temperature;

        return $self;
    }

    public function withFile(string|FileParam $file): self
    {
        $self = clone $this;
        $self['file'] = $file;

        return $self;
    }

    public function withModel(string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    public function withPrompt(?string $prompt): self
    {
        $self = clone $this;
        $self['prompt'] = $prompt;

        return $self;
    }

    public function withResponseFormat(?string $responseFormat): self
    {
        $self = clone $this;
        $self['responseFormat'] = $responseFormat;

        return $self;
    }

    public function withTemperature(?float $temperature): self
    {
        $self = clone $this;
        $self['temperature'] = $temperature;

        return $self;
    }
}
