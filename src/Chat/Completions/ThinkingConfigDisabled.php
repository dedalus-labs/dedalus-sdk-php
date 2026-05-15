<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Schema for ThinkingConfigDisabled.
 *
 * Fields:
 * - type (required): Literal["disabled"]
 *
 * @phpstan-type ThinkingConfigDisabledShape = array{type: 'disabled'}
 */
final class ThinkingConfigDisabled implements BaseModel
{
    /** @use SdkModel<ThinkingConfigDisabledShape> */
    use SdkModel;

    /** @var 'disabled' $type */
    #[Required]
    public string $type = 'disabled';

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
     * @param 'disabled' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
