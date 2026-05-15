<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\ChatCompletionCreateParams;

use DedalusSDK\Chat\Completions\ChatCompletionCreateParams\SafetySetting\Category;
use DedalusSDK\Chat\Completions\ChatCompletionCreateParams\SafetySetting\Threshold;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Safety setting, affecting the safety-blocking behavior.
 *
 * Passing a safety setting for a category changes the allowed probability that
 * content is blocked.
 *
 * Fields:
 * - threshold (required): Literal["HARM_BLOCK_THRESHOLD_UNSPECIFIED", "BLOCK_LOW_AND_ABOVE", "BLOCK_MEDIUM_AND_ABOVE", "BLOCK_ONLY_HIGH", "BLOCK_NONE", "OFF"]
 * - category (required): HarmCategory
 *
 * @phpstan-type SafetySettingShape = array{
 *   category: Category|value-of<Category>,
 *   threshold: Threshold|value-of<Threshold>,
 * }
 */
final class SafetySetting implements BaseModel
{
    /** @use SdkModel<SafetySettingShape> */
    use SdkModel;

    /**
     * Required. The category for this setting.
     *
     * @var value-of<Category> $category
     */
    #[Required(enum: Category::class)]
    public string $category;

    /**
     * Required. Controls the probability threshold at which harm is blocked.
     *
     * @var value-of<Threshold> $threshold
     */
    #[Required(enum: Threshold::class)]
    public string $threshold;

    /**
     * `new SafetySetting()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SafetySetting::with(category: ..., threshold: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SafetySetting)->withCategory(...)->withThreshold(...)
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
     * @param Category|value-of<Category> $category
     * @param Threshold|value-of<Threshold> $threshold
     */
    public static function with(
        Category|string $category,
        Threshold|string $threshold
    ): self {
        $self = new self;

        $self['category'] = $category;
        $self['threshold'] = $threshold;

        return $self;
    }

    /**
     * Required. The category for this setting.
     *
     * @param Category|value-of<Category> $category
     */
    public function withCategory(Category|string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * Required. Controls the probability threshold at which harm is blocked.
     *
     * @param Threshold|value-of<Threshold> $threshold
     */
    public function withThreshold(Threshold|string $threshold): self
    {
        $self = clone $this;
        $self['threshold'] = $threshold;

        return $self;
    }
}
