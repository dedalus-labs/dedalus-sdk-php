<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionTokenLogprob;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Token and its log probability.
 *
 * @phpstan-type TopLogprobShape = array{
 *   token: string, bytes: list<int>|null, logprob: float
 * }
 */
final class TopLogprob implements BaseModel
{
    /** @use SdkModel<TopLogprobShape> */
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
     * `new TopLogprob()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TopLogprob::with(token: ..., bytes: ..., logprob: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TopLogprob)->withToken(...)->withBytes(...)->withLogprob(...)
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
     */
    public static function with(
        string $token,
        ?array $bytes,
        float $logprob
    ): self {
        $self = new self;

        $self['token'] = $token;
        $self['bytes'] = $bytes;
        $self['logprob'] = $logprob;

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
}
