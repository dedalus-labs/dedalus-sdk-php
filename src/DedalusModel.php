<?php

declare(strict_types=1);

namespace DedalusSDK;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Structured model selection entry used in request payloads.
 *
 * Supports OpenAI-style semantics (string model id) while enabling
 * optional per-model default settings for Dedalus multi-model routing.
 *
 * @phpstan-import-type ModelSettingsShape from \DedalusSDK\ModelSettings
 *
 * @phpstan-type DedalusModelShape = array{
 *   model: string, settings?: null|ModelSettings|ModelSettingsShape
 * }
 */
final class DedalusModel implements BaseModel
{
    /** @use SdkModel<DedalusModelShape> */
    use SdkModel;

    /**
     * Model identifier with provider prefix (e.g., 'openai/gpt-5', 'anthropic/claude-3-5-sonnet').
     */
    #[Required]
    public string $model;

    /**
     * Optional default generation settings (e.g., temperature, max_tokens) applied when this model is selected.
     */
    #[Optional(nullable: true)]
    public ?ModelSettings $settings;

    /**
     * `new DedalusModel()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DedalusModel::with(model: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DedalusModel)->withModel(...)
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
     * @param ModelSettings|ModelSettingsShape|null $settings
     */
    public static function with(
        string $model,
        ModelSettings|array|null $settings = null
    ): self {
        $self = new self;

        $self['model'] = $model;

        null !== $settings && $self['settings'] = $settings;

        return $self;
    }

    /**
     * Model identifier with provider prefix (e.g., 'openai/gpt-5', 'anthropic/claude-3-5-sonnet').
     */
    public function withModel(string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * Optional default generation settings (e.g., temperature, max_tokens) applied when this model is selected.
     *
     * @param ModelSettings|ModelSettingsShape|null $settings
     */
    public function withSettings(ModelSettings|array|null $settings): self
    {
        $self = clone $this;
        $self['settings'] = $settings;

        return $self;
    }
}
