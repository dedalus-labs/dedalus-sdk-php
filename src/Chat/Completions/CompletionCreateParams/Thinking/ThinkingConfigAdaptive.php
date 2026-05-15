<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions\CompletionCreateParams\Thinking;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Schema for ThinkingConfigAdaptive.
 *
 * Fields:
 * - type (required): Literal["adaptive"]
 *
 * @phpstan-type ThinkingConfigAdaptiveShape = array{type: 'adaptive'}
 */
final class ThinkingConfigAdaptive implements BaseModel
{
    /** @use SdkModel<ThinkingConfigAdaptiveShape> */
    use SdkModel;

    /** @var 'adaptive' $type */
    #[Required]
    public string $type = 'adaptive';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'adaptive' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
