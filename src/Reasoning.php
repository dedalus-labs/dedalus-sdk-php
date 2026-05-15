<?php

declare(strict_types=1);

namespace DedalusSDK;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\Reasoning\Effort;
use DedalusSDK\Reasoning\GenerateSummary;
use DedalusSDK\Reasoning\Summary;

/**
 * **gpt-5 and o-series models only**.
 *
 * Configuration options for
 * [reasoning models](https://platform.openai.com/docs/guides/reasoning).
 *
 * @phpstan-type ReasoningShape = array{
 *   effort?: null|Effort|value-of<Effort>,
 *   generateSummary?: null|GenerateSummary|value-of<GenerateSummary>,
 *   summary?: null|Summary|value-of<Summary>,
 * }
 */
final class Reasoning implements BaseModel
{
    /** @use SdkModel<ReasoningShape> */
    use SdkModel;

    /** @var value-of<Effort>|null $effort */
    #[Optional(enum: Effort::class, nullable: true)]
    public ?string $effort;

    /** @var value-of<GenerateSummary>|null $generateSummary */
    #[Optional('generate_summary', enum: GenerateSummary::class, nullable: true)]
    public ?string $generateSummary;

    /** @var value-of<Summary>|null $summary */
    #[Optional(enum: Summary::class, nullable: true)]
    public ?string $summary;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Effort|value-of<Effort>|null $effort
     * @param GenerateSummary|value-of<GenerateSummary>|null $generateSummary
     * @param Summary|value-of<Summary>|null $summary
     */
    public static function with(
        Effort|string|null $effort = null,
        GenerateSummary|string|null $generateSummary = null,
        Summary|string|null $summary = null,
    ): self {
        $self = new self;

        null !== $effort && $self['effort'] = $effort;
        null !== $generateSummary && $self['generateSummary'] = $generateSummary;
        null !== $summary && $self['summary'] = $summary;

        return $self;
    }

    /**
     * @param Effort|value-of<Effort>|null $effort
     */
    public function withEffort(Effort|string|null $effort): self
    {
        $self = clone $this;
        $self['effort'] = $effort;

        return $self;
    }

    /**
     * @param GenerateSummary|value-of<GenerateSummary>|null $generateSummary
     */
    public function withGenerateSummary(
        GenerateSummary|string|null $generateSummary
    ): self {
        $self = clone $this;
        $self['generateSummary'] = $generateSummary;

        return $self;
    }

    /**
     * @param Summary|value-of<Summary>|null $summary
     */
    public function withSummary(Summary|string|null $summary): self
    {
        $self = clone $this;
        $self['summary'] = $summary;

        return $self;
    }
}
