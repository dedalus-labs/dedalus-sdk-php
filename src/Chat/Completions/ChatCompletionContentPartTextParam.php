<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Learn about [text inputs](/docs/guides/text-generation).
 *
 * Fields:
 * - type (required): Literal["text"]
 * - text (required): str
 *
 * @phpstan-type ChatCompletionContentPartTextParamShape = array{
 *   text: string, type: 'text'
 * }
 */
final class ChatCompletionContentPartTextParam implements BaseModel
{
    /** @use SdkModel<ChatCompletionContentPartTextParamShape> */
    use SdkModel;

    /**
     * The type of the content part.
     *
     * @var 'text' $type
     */
    #[Required]
    public string $type = 'text';

    /**
     * The text content.
     */
    #[Required]
    public string $text;

    /**
     * `new ChatCompletionContentPartTextParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChatCompletionContentPartTextParam::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChatCompletionContentPartTextParam)->withText(...)
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
    public static function with(string $text): self
    {
        $self = new self;

        $self['text'] = $text;

        return $self;
    }

    /**
     * The text content.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * The type of the content part.
     *
     * @param 'text' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
