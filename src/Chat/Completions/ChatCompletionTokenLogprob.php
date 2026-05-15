<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Chat\Completions\ChatCompletionTokenLogprob\TopLogprob;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Token log probability information.
 *
 * @phpstan-import-type TopLogprobShape from \DedalusSDK\Chat\Completions\ChatCompletionTokenLogprob\TopLogprob
 *
 * @phpstan-type ChatCompletionTokenLogprobShape = array{
 *   token: string,
 *   bytes: list<int>|null,
 *   logprob: float,
 *   topLogprobs: list<TopLogprob|TopLogprobShape>,
 * }
 */
final class ChatCompletionTokenLogprob implements BaseModel
{
    /** @use SdkModel<ChatCompletionTokenLogprobShape> */
    use SdkModel;

    /**
     * The token.
     */
    #[Required]
    public string $token;

    /**
     * A list of integers representing the UTF-8 bytes representation of the token. Useful in instances where characters are represented by multiple tokens and their byte representations must be combined to generate the correct text representation. Can be `null` if there is no bytes representation for the token.
     *
     * @var list<int>|null $bytes
     */
    #[Required(list: 'int')]
    public ?array $bytes;

    /**
     * The log probability of this token, if it is within the top 20 most likely tokens. Otherwise, the value `-9999.0` is used to signify that the token is very unlikely.
     */
    #[Required]
    public float $logprob;

    /**
     * List of the most likely tokens and their log probability, at this token position. In rare cases, there may be fewer than the number of requested `top_logprobs` returned.
     *
     * @var list<TopLogprob> $topLogprobs
     */
    #[Required('top_logprobs', list: TopLogprob::class)]
    public array $topLogprobs;

    /**
     * `new ChatCompletionTokenLogprob()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChatCompletionTokenLogprob::with(
     *   token: ..., bytes: ..., logprob: ..., topLogprobs: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChatCompletionTokenLogprob)
     *   ->withToken(...)
     *   ->withBytes(...)
     *   ->withLogprob(...)
     *   ->withTopLogprobs(...)
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
     * @param list<int>|null $bytes
     * @param list<TopLogprob|TopLogprobShape> $topLogprobs
     */
    public static function with(
        string $token,
        ?array $bytes,
        float $logprob,
        array $topLogprobs
    ): self {
        $self = new self;

        $self['token'] = $token;
        $self['bytes'] = $bytes;
        $self['logprob'] = $logprob;
        $self['topLogprobs'] = $topLogprobs;

        return $self;
    }

    /**
     * The token.
     */
    public function withToken(string $token): self
    {
        $self = clone $this;
        $self['token'] = $token;

        return $self;
    }

    /**
     * A list of integers representing the UTF-8 bytes representation of the token. Useful in instances where characters are represented by multiple tokens and their byte representations must be combined to generate the correct text representation. Can be `null` if there is no bytes representation for the token.
     *
     * @param list<int>|null $bytes
     */
    public function withBytes(?array $bytes): self
    {
        $self = clone $this;
        $self['bytes'] = $bytes;

        return $self;
    }

    /**
     * The log probability of this token, if it is within the top 20 most likely tokens. Otherwise, the value `-9999.0` is used to signify that the token is very unlikely.
     */
    public function withLogprob(float $logprob): self
    {
        $self = clone $this;
        $self['logprob'] = $logprob;

        return $self;
    }

    /**
     * List of the most likely tokens and their log probability, at this token position. In rare cases, there may be fewer than the number of requested `top_logprobs` returned.
     *
     * @param list<TopLogprob|TopLogprobShape> $topLogprobs
     */
    public function withTopLogprobs(array $topLogprobs): self
    {
        $self = clone $this;
        $self['topLogprobs'] = $topLogprobs;

        return $self;
    }
}
