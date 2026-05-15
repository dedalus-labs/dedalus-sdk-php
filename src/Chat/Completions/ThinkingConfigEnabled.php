<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Schema for ThinkingConfigEnabled.
 *
 * Fields:
 * - budget_tokens (required): int
 * - type (required): Literal["enabled"]
 *
 * @phpstan-type ThinkingConfigEnabledShape = array{
 *   budgetTokens: int, type: 'enabled'
 * }
 */
final class ThinkingConfigEnabled implements BaseModel
{
    /** @use SdkModel<ThinkingConfigEnabledShape> */
    use SdkModel;

    /** @var 'enabled' $type */
    #[Required]
    public string $type = 'enabled';

    /**
     * Determines how many tokens Claude can use for its internal reasoning process. Larger budgets can enable more thorough analysis for complex problems, improving response quality.
     *
     * Must be ≥1024 and less than `max_tokens`.
     *
     * See [extended thinking](https://docs.claude.com/en/docs/build-with-claude/extended-thinking) for details.
     */
    #[Required('budget_tokens')]
    public int $budgetTokens;

    /**
     * `new ThinkingConfigEnabled()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ThinkingConfigEnabled::with(budgetTokens: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ThinkingConfigEnabled)->withBudgetTokens(...)
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
    public static function with(int $budgetTokens): self
    {
        $self = new self;

        $self['budgetTokens'] = $budgetTokens;

        return $self;
    }

    /**
     * Determines how many tokens Claude can use for its internal reasoning process. Larger budgets can enable more thorough analysis for complex problems, improving response quality.
     *
     * Must be ≥1024 and less than `max_tokens`.
     *
     * See [extended thinking](https://docs.claude.com/en/docs/build-with-claude/extended-thinking) for details.
     */
    public function withBudgetTokens(int $budgetTokens): self
    {
        $self = clone $this;
        $self['budgetTokens'] = $budgetTokens;

        return $self;
    }

    /**
     * @param 'enabled' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
