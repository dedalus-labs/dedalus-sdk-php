<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Log probability information for the choice.
 *
 * Fields:
 * - content (required): list[ChatCompletionTokenLogprob]
 * - refusal (required): list[ChatCompletionTokenLogprob]
 *
 * @phpstan-import-type ChatCompletionTokenLogprobShape from \DedalusSDK\Chat\Completions\ChatCompletionTokenLogprob
 *
 * @phpstan-type StreamChoiceLogprobsShape = array{
 *   content: list<ChatCompletionTokenLogprob|ChatCompletionTokenLogprobShape>|null,
 *   refusal: list<ChatCompletionTokenLogprob|ChatCompletionTokenLogprobShape>|null,
 * }
 */
final class StreamChoiceLogprobs implements BaseModel
{
    /** @use SdkModel<StreamChoiceLogprobsShape> */
    use SdkModel;

    /**
     * A list of message content tokens with log probability information.
     *
     * @var list<ChatCompletionTokenLogprob>|null $content
     */
    #[Required(list: ChatCompletionTokenLogprob::class)]
    public ?array $content;

    /**
     * A list of message refusal tokens with log probability information.
     *
     * @var list<ChatCompletionTokenLogprob>|null $refusal
     */
    #[Required(list: ChatCompletionTokenLogprob::class)]
    public ?array $refusal;

    /**
     * `new StreamChoiceLogprobs()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * StreamChoiceLogprobs::with(content: ..., refusal: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new StreamChoiceLogprobs)->withContent(...)->withRefusal(...)
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
     * @param list<ChatCompletionTokenLogprob|ChatCompletionTokenLogprobShape>|null $content
     * @param list<ChatCompletionTokenLogprob|ChatCompletionTokenLogprobShape>|null $refusal
     */
    public static function with(?array $content, ?array $refusal): self
    {
        $self = new self;

        $self['content'] = $content;
        $self['refusal'] = $refusal;

        return $self;
    }

    /**
     * A list of message content tokens with log probability information.
     *
     * @param list<ChatCompletionTokenLogprob|ChatCompletionTokenLogprobShape>|null $content
     */
    public function withContent(?array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * A list of message refusal tokens with log probability information.
     *
     * @param list<ChatCompletionTokenLogprob|ChatCompletionTokenLogprobShape>|null $refusal
     */
    public function withRefusal(?array $refusal): self
    {
        $self = clone $this;
        $self['refusal'] = $refusal;

        return $self;
    }
}
