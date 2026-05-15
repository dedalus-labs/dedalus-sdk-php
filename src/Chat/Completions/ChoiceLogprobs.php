<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Log probability information for the choice.
 *
 * @phpstan-import-type ChatCompletionTokenLogprobShape from \DedalusSDK\Chat\Completions\ChatCompletionTokenLogprob
 *
 * @phpstan-type ChoiceLogprobsShape = array{
 *   content?: list<ChatCompletionTokenLogprob|ChatCompletionTokenLogprobShape>|null,
 *   refusal?: list<ChatCompletionTokenLogprob|ChatCompletionTokenLogprobShape>|null,
 * }
 */
final class ChoiceLogprobs implements BaseModel
{
    /** @use SdkModel<ChoiceLogprobsShape> */
    use SdkModel;

    /**
     * A list of message content tokens with log probability information.
     *
     * @var list<ChatCompletionTokenLogprob>|null $content
     */
    #[Optional(list: ChatCompletionTokenLogprob::class, nullable: true)]
    public ?array $content;

    /**
     * A list of message refusal tokens with log probability information.
     *
     * @var list<ChatCompletionTokenLogprob>|null $refusal
     */
    #[Optional(list: ChatCompletionTokenLogprob::class, nullable: true)]
    public ?array $refusal;

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
    public static function with(
        ?array $content = null,
        ?array $refusal = null
    ): self {
        $self = new self;

        null !== $content && $self['content'] = $content;
        null !== $refusal && $self['refusal'] = $refusal;

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
