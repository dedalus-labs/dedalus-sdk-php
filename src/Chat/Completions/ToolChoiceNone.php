<?php

declare(strict_types=1);

namespace DedalusSDK\Chat\Completions;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * The model will not be allowed to use tools.
 *
 * Fields:
 * - type (required): Literal["none"]
 *
 * @phpstan-type ToolChoiceNoneShape = array{type: 'none'}
 */
final class ToolChoiceNone implements BaseModel
{
    /** @use SdkModel<ToolChoiceNoneShape> */
    use SdkModel;

    /** @var 'none' $type */
    #[Required]
    public string $type = 'none';

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
     * @param 'none' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
