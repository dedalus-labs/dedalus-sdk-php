<?php

declare(strict_types=1);

namespace DedalusSDK;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Default response format. Used to generate text responses.
 *
 * Fields:
 * - type (required): Literal["text"]
 *
 * @phpstan-type ResponseFormatTextShape = array{type: 'text'}
 */
final class ResponseFormatText implements BaseModel
{
    /** @use SdkModel<ResponseFormatTextShape> */
    use SdkModel;

    /**
     * The type of response format being defined. Always `text`.
     *
     * @var 'text' $type
     */
    #[Required]
    public string $type = 'text';

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
     * The type of response format being defined. Always `text`.
     *
     * @param 'text' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
