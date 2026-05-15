<?php

declare(strict_types=1);

namespace DedalusSDK;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * JSON object response format. An older method of generating JSON responses.
 * Using `json_schema` is recommended for models that support it. Note that the
 * model will not generate JSON without a system or user message instructing it
 * to do so.
 *
 * Fields:
 * - type (required): Literal["json_object"]
 *
 * @phpstan-type ResponseFormatJSONObjectShape = array{type: 'json_object'}
 */
final class ResponseFormatJSONObject implements BaseModel
{
    /** @use SdkModel<ResponseFormatJSONObjectShape> */
    use SdkModel;

    /**
     * The type of response format being defined. Always `json_object`.
     *
     * @var 'json_object' $type
     */
    #[Required]
    public string $type = 'json_object';

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
     * The type of response format being defined. Always `json_object`.
     *
     * @param 'json_object' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
