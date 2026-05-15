<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Usage statistics for the completion request.
 *
 * Fields:
 * - completion_tokens (required): int
 * - prompt_tokens (required): int
 * - total_tokens (required): int
 * - completion_tokens_details (optional): CompletionTokensDetails
 * - prompt_tokens_details (optional): PromptTokensDetails
 *
 * @phpstan-import-type CompletionTokensDetailsShape from \DedalusSDK\Chat\Completions\CompletionTokensDetails
 * @phpstan-import-type PromptTokensDetailsShape from \DedalusSDK\Chat\Completions\PromptTokensDetails
 *
 * @phpstan-type CompletionUsageShape = array{
 *   completionTokens: int,
 *   promptTokens: int,
 *   totalTokens: int,
 *   completionTokensDetails?: null|CompletionTokensDetails|CompletionTokensDetailsShape,
 *   promptTokensDetails?: null|PromptTokensDetails|PromptTokensDetailsShape,
 * }
 */
final class CompletionUsage implements BaseModel
{
    /** @use SdkModel<CompletionUsageShape> */
    use SdkModel;

    /**
     * Number of tokens in the generated completion.
     */
    #[Required('completion_tokens')]
    public int $completionTokens;

    /**
     * Number of tokens in the prompt.
     */
    #[Required('prompt_tokens')]
    public int $promptTokens;

    /**
     * Total number of tokens used in the request (prompt + completion).
     */
    #[Required('total_tokens')]
    public int $totalTokens;

    /**
     * Breakdown of tokens used in a completion.
     */
    #[Optional('completion_tokens_details')]
    public ?CompletionTokensDetails $completionTokensDetails;

    /**
     * Breakdown of tokens used in the prompt.
     */
    #[Optional('prompt_tokens_details')]
    public ?PromptTokensDetails $promptTokensDetails;

    /**
     * `new CompletionUsage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CompletionUsage::with(
     *   completionTokens: ..., promptTokens: ..., totalTokens: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CompletionUsage)
     *   ->withCompletionTokens(...)
     *   ->withPromptTokens(...)
     *   ->withTotalTokens(...)
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
     * @param CompletionTokensDetails|CompletionTokensDetailsShape|null $completionTokensDetails
     * @param PromptTokensDetails|PromptTokensDetailsShape|null $promptTokensDetails
     */
    public static function with(
        int $completionTokens,
        int $promptTokens,
        int $totalTokens,
        CompletionTokensDetails|array|null $completionTokensDetails = null,
        PromptTokensDetails|array|null $promptTokensDetails = null,
    ): self {
        $self = new self;

        $self['completionTokens'] = $completionTokens;
        $self['promptTokens'] = $promptTokens;
        $self['totalTokens'] = $totalTokens;

        null !== $completionTokensDetails && $self['completionTokensDetails'] = $completionTokensDetails;
        null !== $promptTokensDetails && $self['promptTokensDetails'] = $promptTokensDetails;

        return $self;
    }

    /**
     * Number of tokens in the generated completion.
     */
    public function withCompletionTokens(int $completionTokens): self
    {
        $self = clone $this;
        $self['completionTokens'] = $completionTokens;

        return $self;
    }

    /**
     * Number of tokens in the prompt.
     */
    public function withPromptTokens(int $promptTokens): self
    {
        $self = clone $this;
        $self['promptTokens'] = $promptTokens;

        return $self;
    }

    /**
     * Total number of tokens used in the request (prompt + completion).
     */
    public function withTotalTokens(int $totalTokens): self
    {
        $self = clone $this;
        $self['totalTokens'] = $totalTokens;

        return $self;
    }

    /**
     * Breakdown of tokens used in a completion.
     *
     * @param CompletionTokensDetails|CompletionTokensDetailsShape $completionTokensDetails
     */
    public function withCompletionTokensDetails(
        CompletionTokensDetails|array $completionTokensDetails
    ): self {
        $self = clone $this;
        $self['completionTokensDetails'] = $completionTokensDetails;

        return $self;
    }

    /**
     * Breakdown of tokens used in the prompt.
     *
     * @param PromptTokensDetails|PromptTokensDetailsShape $promptTokensDetails
     */
    public function withPromptTokensDetails(
        PromptTokensDetails|array $promptTokensDetails
    ): self {
        $self = clone $this;
        $self['promptTokensDetails'] = $promptTokensDetails;

        return $self;
    }
}
