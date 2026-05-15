<?php

declare(strict_types=1);

namespace DedalusSDK;

use DedalusSDK\Core\Attributes\Optional;
use DedalusSDK\Core\Attributes\Required;
use DedalusSDK\Core\Concerns\SdkModel;
use DedalusSDK\Core\Contracts\BaseModel;

/**
 * Structured MCP server specification.
 *
 * Slug-based: {"slug": "dedalus-labs/brave-search", "name": "github-integration", "version": "v1.0.0"}
 * URL-based:  {"url": "https://mcp.dedaluslabs.ai/acme/my-server/mcp", "name": "custom-server"}
 *
 * @phpstan-type MCPServerSpecShape = array{
 *   name: string,
 *   credentials?: array<string,string>|null,
 *   slug?: string|null,
 *   url?: string|null,
 *   version?: string|null,
 * }
 */
final class MCPServerSpec implements BaseModel
{
    /** @use SdkModel<MCPServerSpecShape> */
    use SdkModel;

    /**
     * Server instance name for credential matching.
     */
    #[Required]
    public string $name;

    /**
     * Encrypted credential blobs keyed by connection name. Values are base64url ciphertext produced by the SDK (client-side encryption with the AS public key).
     *
     * @var array<string,string>|null $credentials
     */
    #[Optional(map: 'string', nullable: true)]
    public ?array $credentials;

    /**
     * Marketplace identifier.
     */
    #[Optional(nullable: true)]
    public ?string $slug;

    /**
     * Direct URL to MCP server endpoint (Pro users).
     */
    #[Optional(nullable: true)]
    public ?string $url;

    /**
     * Version constraint for slug-based servers.
     */
    #[Optional(nullable: true)]
    public ?string $version;

    /**
     * `new MCPServerSpec()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MCPServerSpec::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MCPServerSpec)->withName(...)
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
     * @param array<string,string>|null $credentials
     */
    public static function with(
        string $name,
        ?array $credentials = null,
        ?string $slug = null,
        ?string $url = null,
        ?string $version = null,
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $credentials && $self['credentials'] = $credentials;
        null !== $slug && $self['slug'] = $slug;
        null !== $url && $self['url'] = $url;
        null !== $version && $self['version'] = $version;

        return $self;
    }

    /**
     * Server instance name for credential matching.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Encrypted credential blobs keyed by connection name. Values are base64url ciphertext produced by the SDK (client-side encryption with the AS public key).
     *
     * @param array<string,string>|null $credentials
     */
    public function withCredentials(?array $credentials): self
    {
        $self = clone $this;
        $self['credentials'] = $credentials;

        return $self;
    }

    /**
     * Marketplace identifier.
     */
    public function withSlug(?string $slug): self
    {
        $self = clone $this;
        $self['slug'] = $slug;

        return $self;
    }

    /**
     * Direct URL to MCP server endpoint (Pro users).
     */
    public function withURL(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Version constraint for slug-based servers.
     */
    public function withVersion(?string $version): self
    {
        $self = clone $this;
        $self['version'] = $version;

        return $self;
    }
}
