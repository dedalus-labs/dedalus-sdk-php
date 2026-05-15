<?php

declare(strict_types=1);

namespace DedalusSDK\ToolChoice;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * @phpstan-type MCPToolChoiceShape = array{name: string, serverLabel: string}
 */
final class MCPToolChoice implements BaseModel
{
    /** @use SdkModel<MCPToolChoiceShape> */
    use SdkModel;

    #[Required]
    public string $name;

    #[Required('server_label')]
    public string $serverLabel;

    /**
     * `new MCPToolChoice()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MCPToolChoice::with(name: ..., serverLabel: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MCPToolChoice)->withName(...)->withServerLabel(...)
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
    public static function with(string $name, string $serverLabel): self
    {
        $self = new self;

        $self['name'] = $name;
        $self['serverLabel'] = $serverLabel;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withServerLabel(string $serverLabel): self
    {
        $self = clone $this;
        $self['serverLabel'] = $serverLabel;

        return $self;
    }
}
