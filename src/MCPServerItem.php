<?php

declare(strict_types=1);

namespace DedalusSDK;

use DedalusSDK\Core\Concerns\SdkUnion;
use DedalusSDK\Core\Conversion\Contracts\Converter;
use DedalusSDK\Core\Conversion\Contracts\ConverterSource;

/**
 * Structured MCP server specification.
 *
 * Slug-based: {"slug": "dedalus-labs/brave-search", "name": "github-integration", "version": "v1.0.0"}
 * URL-based:  {"url": "https://mcp.dedaluslabs.ai/acme/my-server/mcp", "name": "custom-server"}
 *
 * @phpstan-import-type MCPServerSpecShape from \DedalusSDK\MCPServerSpec
 *
 * @phpstan-type MCPServerItemVariants = string|MCPServerSpec
 * @phpstan-type MCPServerItemShape = MCPServerItemVariants|MCPServerSpecShape
 */
final class MCPServerItem implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', MCPServerSpec::class];
    }
}
