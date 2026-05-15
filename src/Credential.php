<?php

declare(strict_types=1);

namespace DedalusSDK;

use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;
use DedalusSDK\Credential\Value;

/**
 * Credential for MCP server authentication.
 *
 * Passed at endpoint level (e.g., chat.completions.create) and matched
 * to MCP servers by connection name. Wire format matches dedalus_mcp.Credential.to_dict().
 *
 * @phpstan-import-type ValueVariants from \DedalusSDK\Credential\Value
 * @phpstan-import-type ValueShape from \DedalusSDK\Credential\Value
 *
 * @phpstan-type CredentialShape = array{
 *   connectionName: string, values: array<string,ValueShape>
 * }
 */
final class Credential implements BaseModel
{
    /** @use SdkModel<CredentialShape> */
    use SdkModel;

    /**
     * Connection name. Must match a connection in MCPServer.connections.
     */
    #[Required('connection_name')]
    public string $connectionName;

    /**
     * Credential values. Keys are credential field names, values are the secrets.
     *
     * @var array<string,ValueVariants> $values
     */
    #[Required(map: Value::class)]
    public array $values;

    /**
     * `new Credential()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Credential::with(connectionName: ..., values: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Credential)->withConnectionName(...)->withValues(...)
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
     * @param array<string,ValueShape> $values
     */
    public static function with(string $connectionName, array $values): self
    {
        $self = new self;

        $self['connectionName'] = $connectionName;
        $self['values'] = $values;

        return $self;
    }

    /**
     * Connection name. Must match a connection in MCPServer.connections.
     */
    public function withConnectionName(string $connectionName): self
    {
        $self = clone $this;
        $self['connectionName'] = $connectionName;

        return $self;
    }

    /**
     * Credential values. Keys are credential field names, values are the secrets.
     *
     * @param array<string,ValueShape> $values
     */
    public function withValues(array $values): self
    {
        $self = clone $this;
        $self['values'] = $values;

        return $self;
    }
}
