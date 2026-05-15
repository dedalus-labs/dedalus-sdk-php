<?php

declare(strict_types=1);

namespace DedalusSDK\Embeddings\CreateEmbeddingResponse;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * The usage information for the request.
 *
 * @phpstan-type UsageShape = array{promptTokens: int, totalTokens: int}
 */
final class Usage implements BaseModel
{
    /** @use SdkModel<UsageShape> */
    use SdkModel;

    /**
     * The number of tokens used by the prompt.
     */
    #[Required('prompt_tokens')]
    public int $promptTokens;

    /**
     * The total number of tokens used by the request.
     */
    #[Required('total_tokens')]
    public int $totalTokens;

    /**
     * `new Usage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Usage::with(promptTokens: ..., totalTokens: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Usage)->withPromptTokens(...)->withTotalTokens(...)
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
    public static function with(int $promptTokens, int $totalTokens): self
    {
        $self = new self;

        $self['promptTokens'] = $promptTokens;
        $self['totalTokens'] = $totalTokens;

        return $self;
    }

    /**
     * The number of tokens used by the prompt.
     */
    public function withPromptTokens(int $promptTokens): self
    {
        $self = clone $this;
        $self['promptTokens'] = $promptTokens;

        return $self;
    }

    /**
     * The total number of tokens used by the request.
     */
    public function withTotalTokens(int $totalTokens): self
    {
        $self = clone $this;
        $self['totalTokens'] = $totalTokens;

        return $self;
    }
}
