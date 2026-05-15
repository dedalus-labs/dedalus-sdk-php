<?php

declare(strict_types=1);

namespace DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON\Usage;

use DedalusSDK\Chat\Completions\InputTokenDetails;
use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Usage statistics for models billed by token usage.
 *
 * Fields:
 *   - type (required): Literal['tokens']
 *   - input_tokens (required): int
 *   - input_token_details (optional): InputTokenDetails
 *   - output_tokens (required): int
 *   - total_tokens (required): int
 *
 * @phpstan-import-type InputTokenDetailsShape from \DedalusSDK\Chat\Completions\InputTokenDetails
 *
 * @phpstan-type TranscriptTextUsageTokensShape = array{
 *   inputTokens: int,
 *   outputTokens: int,
 *   totalTokens: int,
 *   type: 'tokens',
 *   inputTokenDetails?: null|InputTokenDetails|InputTokenDetailsShape,
 * }
 */
final class TranscriptTextUsageTokens implements BaseModel
{
    /** @use SdkModel<TranscriptTextUsageTokensShape> */
    use SdkModel;

    /**
     * The type of the usage object. Always `tokens` for this variant.
     *
     * @var 'tokens' $type
     */
    #[Required]
    public string $type = 'tokens';

    /**
     * Number of input tokens billed for this request.
     */
    #[Required('input_tokens')]
    public int $inputTokens;

    /**
     * Number of output tokens generated.
     */
    #[Required('output_tokens')]
    public int $outputTokens;

    /**
     * Total number of tokens used (input + output).
     */
    #[Required('total_tokens')]
    public int $totalTokens;

    /**
     * Details about the input tokens billed for this request.
     */
    #[Optional('input_token_details')]
    public ?InputTokenDetails $inputTokenDetails;

    /**
     * `new TranscriptTextUsageTokens()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TranscriptTextUsageTokens::with(
     *   inputTokens: ..., outputTokens: ..., totalTokens: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TranscriptTextUsageTokens)
     *   ->withInputTokens(...)
     *   ->withOutputTokens(...)
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
     * @param InputTokenDetails|InputTokenDetailsShape|null $inputTokenDetails
     */
    public static function with(
        int $inputTokens,
        int $outputTokens,
        int $totalTokens,
        InputTokenDetails|array|null $inputTokenDetails = null,
    ): self {
        $self = new self;

        $self['inputTokens'] = $inputTokens;
        $self['outputTokens'] = $outputTokens;
        $self['totalTokens'] = $totalTokens;

        null !== $inputTokenDetails && $self['inputTokenDetails'] = $inputTokenDetails;

        return $self;
    }

    /**
     * Number of input tokens billed for this request.
     */
    public function withInputTokens(int $inputTokens): self
    {
        $self = clone $this;
        $self['inputTokens'] = $inputTokens;

        return $self;
    }

    /**
     * Number of output tokens generated.
     */
    public function withOutputTokens(int $outputTokens): self
    {
        $self = clone $this;
        $self['outputTokens'] = $outputTokens;

        return $self;
    }

    /**
     * Total number of tokens used (input + output).
     */
    public function withTotalTokens(int $totalTokens): self
    {
        $self = clone $this;
        $self['totalTokens'] = $totalTokens;

        return $self;
    }

    /**
     * The type of the usage object. Always `tokens` for this variant.
     *
     * @param 'tokens' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Details about the input tokens billed for this request.
     *
     * @param InputTokenDetails|InputTokenDetailsShape $inputTokenDetails
     */
    public function withInputTokenDetails(
        InputTokenDetails|array $inputTokenDetails
    ): self {
        $self = clone $this;
        $self['inputTokenDetails'] = $inputTokenDetails;

        return $self;
    }
}
