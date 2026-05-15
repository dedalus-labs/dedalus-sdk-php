<?php

declare(strict_types=1);

namespace DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse;

use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON\Logprob;
use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON\Usage;
use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON\Usage\TranscriptTextUsageDuration;
use DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON\Usage\TranscriptTextUsageTokens;
use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Represents a transcription response returned by model, based on the provided input.
 *
 * Fields:
 *   - text (required): str
 *   - logprobs (optional): list[LogprobsItem]
 *   - usage (optional): Usage
 *
 * @phpstan-import-type UsageVariants from \DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON\Usage
 * @phpstan-import-type LogprobShape from \DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON\Logprob
 * @phpstan-import-type UsageShape from \DedalusSDK\Audio\Transcriptions\TranscriptionNewResponse\CreateTranscriptionResponseJSON\Usage
 *
 * @phpstan-type CreateTranscriptionResponseJSONShape = array{
 *   text: string,
 *   logprobs?: list<Logprob|LogprobShape>|null,
 *   usage?: UsageShape|null,
 * }
 */
final class CreateTranscriptionResponseJSON implements BaseModel
{
    /** @use SdkModel<CreateTranscriptionResponseJSONShape> */
    use SdkModel;

    /**
     * The transcribed text.
     */
    #[Required]
    public string $text;

    /**
     * The log probabilities of the tokens in the transcription. Only returned with the models `gpt-4o-transcribe` and `gpt-4o-mini-transcribe` if `logprobs` is added to the `include` array.
     *
     * @var list<Logprob>|null $logprobs
     */
    #[Optional(list: Logprob::class)]
    public ?array $logprobs;

    /**
     * Token usage statistics for the request.
     *
     * @var UsageVariants|null $usage
     */
    #[Optional(union: Usage::class)]
    public TranscriptTextUsageTokens|TranscriptTextUsageDuration|null $usage;

    /**
     * `new CreateTranscriptionResponseJSON()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CreateTranscriptionResponseJSON::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CreateTranscriptionResponseJSON)->withText(...)
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
     * @param list<Logprob|LogprobShape>|null $logprobs
     * @param UsageShape|null $usage
     */
    public static function with(
        string $text,
        ?array $logprobs = null,
        TranscriptTextUsageTokens|array|TranscriptTextUsageDuration|null $usage = null,
    ): self {
        $self = new self;

        $self['text'] = $text;

        null !== $logprobs && $self['logprobs'] = $logprobs;
        null !== $usage && $self['usage'] = $usage;

        return $self;
    }

    /**
     * The transcribed text.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * The log probabilities of the tokens in the transcription. Only returned with the models `gpt-4o-transcribe` and `gpt-4o-mini-transcribe` if `logprobs` is added to the `include` array.
     *
     * @param list<Logprob|LogprobShape> $logprobs
     */
    public function withLogprobs(array $logprobs): self
    {
        $self = clone $this;
        $self['logprobs'] = $logprobs;

        return $self;
    }

    /**
     * Token usage statistics for the request.
     *
     * @param UsageShape $usage
     */
    public function withUsage(
        TranscriptTextUsageTokens|array|TranscriptTextUsageDuration $usage
    ): self {
        $self = clone $this;
        $self['usage'] = $usage;

        return $self;
    }
}
