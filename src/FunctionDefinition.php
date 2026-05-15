<?php

declare(strict_types=1);

namespace DedalusSDK;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Schema for Function.
 *
 * Fields:
 * - name (required): str
 *
 * @phpstan-type FunctionDefinitionShape = array{name: string}
 */
final class FunctionDefinition implements BaseModel
{
    /** @use SdkModel<FunctionDefinitionShape> */
    use SdkModel;

    /**
     * The name of the function to call.
     */
    #[Required]
    public string $name;

    /**
     * `new FunctionDefinition()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FunctionDefinition::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FunctionDefinition)->withName(...)
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
    public static function with(string $name): self
    {
        $self = new self;

        $self['name'] = $name;

        return $self;
    }

    /**
     * The name of the function to call.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
